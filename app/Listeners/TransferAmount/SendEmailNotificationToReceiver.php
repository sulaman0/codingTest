<?php

namespace App\Listeners\TransferAmount;

use App\Events\TransferAmountEvent;
use App\Mail\SendEmailToReceiver;
use App\Models\UserModel\UserModel;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationToReceiver
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
        ## get Receiver Email Address
        $EmailAddress = UserModel::getUser($event->transferMoney->transfer_to)->user_email;
        Mail::to($EmailAddress)->send(new SendEmailToReceiver());
    }
}
