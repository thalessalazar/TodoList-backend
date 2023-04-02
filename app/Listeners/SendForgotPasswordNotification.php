<?php

namespace App\Listeners;

use App\Events\PasswordResetRequested;
use App\Mail\ForgotPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PasswordResetRequested $event)
    {
        Mail::to($event->user->email)->send(new ForgotPasswordMail($event->passwordReset, $event->user));
    }
}
