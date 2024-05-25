<?php

namespace App\Events;

use App\Models\Position;

class PositionUpdated
{
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
