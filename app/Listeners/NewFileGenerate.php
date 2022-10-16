<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewFileGenerate
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
    public function handle($event)
    {
        $user=User::find($event->user->id);
        Notification::send($user,new NewFile($event->user));
        
    }
}
