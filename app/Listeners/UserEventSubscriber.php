<?php

namespace App\Listeners;

use App\Abstractions\Listeners\BaseEventSubscriber;
use App\Events\UserRegisterEvent;
use App\Notifications\WelcomeNotification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber extends BaseEventSubscriber
{
    /**
     * @param UserRegisterEvent $event
     */
    public function onUserRegister(UserRegisterEvent $event): void {
        $event->user->notify(new WelcomeNotification($event->verification));
    }

    /**
     * @inerhitDoc
     */
    public function subscribe(Dispatcher $dispatcher): array
    {
        return [
            UserRegisterEvent::class => 'onUserRegister'
        ];
    }
}