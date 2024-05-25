<?php

namespace App\Events;

use App\Models\Position;
use Illuminate\Queue\SerializesModels;

class PositionUpdated
{
    use SerializesModels;

    public Position $position;

    /**
     * Create a new event instance.
     *
     * @param Position $position
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }
}
