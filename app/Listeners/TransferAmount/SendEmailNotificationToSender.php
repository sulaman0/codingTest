<?php

namespace App\Listeners\TransferAmount;

use App\Events\TransferAmountEvent;
use App\Mail\SendEmailToSender;
use App\Models\UserModel\UserModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationToSender
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
     * @param TransferAmountEvent $event
     *
     * @return void
     */
    public function handle(TransferAmountEvent $event)
    {
        ## get Sender Email Address
        $EmailAddress = UserModel::getUser($event->transferMoney->transfer_from)->user_email;
        Mail::to($EmailAddress)->send(new SendEmailToSender());
    }

}
