<?php

namespace App\Mail;

use App\Models\ContactUsRequest;
use App\Models\Country;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsRequestMailable extends Mailable
{
    use Queueable, SerializesModels;
    protected $contact_us_request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactUsRequest $contact_us_request)
    {
        $this->contact_us_request = $contact_us_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $country = Country::find($this->contact_us_request->country_id);
        return $this->to(config('mail.feedback.to_address'))
            ->from(config('mail.feedback.from_address'))
            ->cc($this->contact_us_request->email)
            ->replyTo($this->contact_us_request->email)
            ->subject('Your '.env('APP_NAME').' Contact Us Request')
            ->view('Emails/ContactUsRequestMailBody')
            ->with([

                'name' => $this->contact_us_request->first_name. " ". $this->contact_us_request->middle_name. " ". $this->contact_us_request->last_name,
                'first_name'=>$this->contact_us_request->first_name,
                'middle_name' => $this->contact_us_request->middle_name,
                'last_name' => $this->contact_us_request->last_name,
                'email'=>$this->contact_us_request->email,
                'company_name' => $this->contact_us_request->company_name,
                'professional_area' => $this->contact_us_request->professional_area,
                'phone_number' => $this->contact_us_request->phone_number,
                'country' => getSessionLanguageShortCode()=='en'? $country->name : $country->name_lan,
                'detail' => $this->contact_us_request->detail
            ]);
    }
}
