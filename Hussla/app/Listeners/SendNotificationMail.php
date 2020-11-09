<?php

namespace App\Listeners;

use App\Events\FreeOneYearSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyFreeSub;

class SendNotificationMail
{

    /**
     * Handle the event.
     *
     * @param  FreeOneYearSubscription  $event
     * @return void
     */
    public function handle(FreeOneYearSubscription $event)
    {
        Mail::to($event->user->email)->send(new NotifyFreeSub($event->user));
    }
}
