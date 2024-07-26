<?php

namespace App\Providers;

use App\Events\ExceptionEvent;
use App\Events\NewOrderCreatedEvent;
use App\Events\OrderCanceledEvent;
use App\Events\OrderStatusChangedEvent;
use App\Listeners\ExceptionListener;
use App\Listeners\NotifyBuyerNewOrderListener;
use App\Listeners\NotifyBuyerOrderCanceledListener;
use App\Listeners\NotifyChangeOrderStatusListener;
use App\Listeners\NotifySupplierNewOrderListener;
use App\Listeners\NotifySupplierOrderCanceledListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewOrderCreatedEvent::class => [
            NotifyBuyerNewOrderListener::class,
            NotifySupplierNewOrderListener::class,
        ],
        OrderCanceledEvent::class => [
            NotifySupplierOrderCanceledListener::class,
            NotifyBuyerOrderCanceledListener::class,
        ],
        OrderStatusChangedEvent::class => [
            NotifyChangeOrderStatusListener::class,
        ],
        ExceptionEvent::class => [
            ExceptionListener::class,

        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
