<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendEmailEvent $event): void
    {
        //
        sleep(5);
        Mail::to($event->user->email)->send(new SendMail($event->user));
       
    }
}
