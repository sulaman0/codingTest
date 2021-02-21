<?php

namespace App\Events;

use App\Http\Requests\TransferMoney\DemoAccountRequest;
use App\Http\Requests\TransferMoney\TransferMoney;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransferAmountEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var TransferMoney
     */
    public $transferMoney;

    public function __construct(TransferMoney $transferMoney)
    {
        $this->transferMoney = $transferMoney;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
