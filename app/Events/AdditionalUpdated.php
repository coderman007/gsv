<?php

namespace App\Events;

use App\Models\Additional;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdditionalUpdated
{
    use Dispatchable, SerializesModels;

    public Additional $additional;

    public function __construct(Additional $additional)
    {
        $this->additional = $additional;
    }
}
