<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $supplier;

    public $buyer;

    public $details;

    /**
     * Create a new event instance.
     */
    public function __construct($supplier, $buyer, $details)
    {
        $this->supplier = $supplier;
        $this->buyer = $buyer;
        $this->details = $details;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
