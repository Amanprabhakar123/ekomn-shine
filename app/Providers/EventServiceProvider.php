<?php

namespace App\Providers;

use App\Events\ExceptionEvent;
use PhpParser\Node\Stmt\Return_;
use App\Events\ReturnRaisedEvent;
use App\Events\OrderCanceledEvent;
use App\Events\NewOrderCreatedEvent;
use App\Listeners\ExceptionListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\OrderStatusChangedEvent;
use App\Events\ReturnDeclinedApprovedEvent;
use App\Listeners\ReturnRaisedListener;
use App\Events\SupplierPaymentDisburseEvent;
use App\Listeners\NotifyBuyerNewOrderListener;
use App\Listeners\NotifySupplierNewOrderListener;
use App\Listeners\NotifyChangeOrderStatusListener;
use App\Listeners\SupplierPaymentDisburseListener;
use App\Listeners\NotifyBuyerOrderCanceledListener;
use App\Listeners\NotifySupplierOrderCanceledListener;
use App\Listeners\ReturnDeclinedApprovedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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

        SupplierPaymentDisburseEvent::class => [
            SupplierPaymentDisburseListener::class,
        ],

        ReturnRaisedEvent::class => [
            ReturnRaisedListener::class,
        ],

        ReturnDeclinedApprovedEvent::class => [
            ReturnDeclinedApprovedListener::class,
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
