<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details){
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->details['subject'])->view('emails.promotion_notification', ['subject' => $this->details['subject'],
        'home' => $this->details['home'],
        'name' => $this->details['name'], 'image' => $this->details['image'],
        'logo' => $this->details['logo'], 'link' => $this->details['link']]);
    }
}
