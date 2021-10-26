<?php


namespace App\Services;

use \Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class MailChimpCampaign implements IRSSCampaign
{
    protected $key;
    protected $data_center;
    protected $api_version;
    protected $timeouts;
    protected $audience_id;
    protected $end_point_base_url;

    function __construct()
    {
        $this->config();
    }

    /**
     * config channel
     * @return void
     */
    function config()
    {
        $this->key = Config::get('mailchimp.key');
        $this->data_center = Config::get('mailchimp.dc');
        $this->api_version = Config::get('mailchimp.api_version');
        $this->timeouts = Config::get('mailchimp.timeouts');
        $this->audience_id = Config::get('mailchimp.audience_id');
        $this->end_point_base_url = "https://{$this->data_center}.api.mailchimp.com/{$this->api_version}/";
    }

    /**
     * check if subscriber exists
     * @param $email
     * @return bool
     */
    function isOnList($email)
    {
        $subscriber_hash = md5($email);
        $url = $this->end_point_base_url."lists/{$this->audience_id}/members/{$subscriber_hash}";
        $response = Http::timeout($this->timeouts)->withToken($this->key)->get($url, [
            "email_address" => $email
        ]);

        return false;
    }

    /**
     * add new subscriber
     * @param $email
     * @return bool
     */
    function subscribe($email)
    {
        $url = $this->end_point_base_url."lists/{$this->audience_id}/members";
        $response = Http::timeout($this->timeouts)->withToken($this->key)->post($url, [
            "email_address" => $email,
            "status" => "pending",
            "email_type"=>'html'
        ]);

        if(!$response->ok()) {
            $res = json_decode($response->body(), true);
            if($res['title']=="Member Exists"){
                throw new RSSMemeberExistedException("Sorry, you have already subscribed to our RSS channel!");
            }
            else throw new Exception($res['title']);
        }

        return true;
    }

    /**
     * get subscribers list
     * @return array
     */
    function fetchSubscribers()
    {
        $url = $this->end_point_base_url."lists/{$this->audience_id}/members";
        $response = Http::timeout($this->timeouts)->withToken($this->key)->get($url);

        if($response->ok()){
            return $response->body()->members;
        }
        else{
            return [];
        }
    }

    /**
     * get number of subscribers
     * @return int
     */
    function countSubscribers()
    {
        $url = $this->end_point_base_url."lists/{$this->audience_id}/members";
        $response = Http::timeout($this->timeouts)->withToken($this->key)->get($url);

        if($response->ok()){
            return $response->body()->total_items;
        }
        else{
            return 0;
        }
    }

    /**
     * @param $email
     * @return bool
     */
    function removeSubscriber($email)
    {
        $subscriber_hash = md5($email);
        $url = $this->end_point_base_url."lists/{$this->audience_id}/members/{$subscriber_hash}/actions/delete-permanent";
        $response = Http::timeout($this->timeouts)->withToken($this->key)->delete($url);

        if($response->ok())
        {
            return true;
        }

        return false;
    }
}
