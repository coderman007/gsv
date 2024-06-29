<?php

namespace App\Providers;

use App\Events\AdditionalUpdated;
use App\Events\CommercialPolicyUpdated;
use App\Events\MaterialUpdated;
use App\Events\PositionUpdated;
use App\Events\ToolUpdated;
use App\Events\TransportUpdated;
use App\Listeners\RecalculateAdditionalCosts;
use App\Listeners\RecalculateMaterialCosts;
use App\Listeners\RecalculatePositionCosts;
use App\Listeners\RecalculateProjectSaleValue;
use App\Listeners\RecalculateToolCosts;
use App\Listeners\RecalculateTransportCosts;
use App\Models\Project;
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
        PositionUpdated::class => [
            RecalculatePositionCosts::class,
        ],
        ToolUpdated::class => [
            RecalculateToolCosts::class,
        ],
        MaterialUpdated::class => [
            RecalculateMaterialCosts::class,
        ],
        TransportUpdated::class => [
            RecalculateTransportCosts::class,
        ],
        AdditionalUpdated::class => [
            RecalculateAdditionalCosts::class,
        ],
        CommercialPolicyUpdated::class => [
            RecalculateProjectSaleValue::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
