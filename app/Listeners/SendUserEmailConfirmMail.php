<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\UserEmailConfirmMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmailConfirmMail
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
    public function handle(UserCreated $event): void
    {
        Mail::to($event->user->email)->send(new UserEmailConfirmMail($event->user));

    }
}
