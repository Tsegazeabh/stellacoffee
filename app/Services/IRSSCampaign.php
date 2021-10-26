<?php


namespace App\Services;



interface IRSSCampaign
{
    /***
     * config channel
     * check if subscriber exists
     * subscribe
     * get subscribers list
     * get number of subscribers
     * remove subscriber
     */

    /**
     * config channel
     * @return void
     */
    function config();

    /**
     * check if subscriber exists
     * @param $email
     * @return bool
     */
    function isOnList($email);

    /**
     * add new subscriber
     * @param $email
     * @return bool
     */
    function subscribe($email);

    /**
     * get subscribers list
     * @return array
     */
    function fetchSubscribers();

    /**
     * get number of subscribers
     * @return int
     */
    function countSubscribers();

    /**
     * @param $email
     * @return bool
     */
    function removeSubscriber($email);
}
