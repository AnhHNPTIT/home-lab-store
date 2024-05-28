<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\SendEmail;

class SendPromotionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details['home'] = $this->data['home'];
        $details['subject'] = $this->data['subject'];
        $details['logo'] = $this->data['logo'];
        $details['name'] = $this->data['name'];
        $details['link'] = $this->data['link'];
        $details['image'] = $this->data['image'];

        Mail::to($this->data['email'])->send(new SendEmail($details));
    }
}
