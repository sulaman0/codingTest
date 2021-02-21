<?php

namespace App\Providers;

use App\Events\TransferAmountEvent;
use App\Listeners\TransferAmount\CreateCreditListener;
use App\Listeners\TransferAmount\CreateDebitListener;
use App\Listeners\TransferAmount\SendEmailNotificationToReceiver;
use App\Listeners\TransferAmount\SendEmailNotificationToSender;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TransferAmountEvent::class => [
            SendEmailNotificationToReceiver::class,
            SendEmailNotificationToSender::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
