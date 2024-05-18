<?php

namespace App\Providers;

use App\Events\PositionUpdated;
use App\Events\ProofUpdated;
use App\Listeners\UpdateAPUsOnPositionChange;
use App\Listeners\UpdateProofValue;
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
            UpdateAPUsOnPositionChange::class,
        ],
        ProofUpdated::class => [
            UpdateProofValue::class,
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
