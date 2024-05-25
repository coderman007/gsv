<?php

namespace App\Events;

use App\Models\Transport;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransportUpdated
{
    use Dispatchable, SerializesModels;

    public Transport $transport;

    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }
}

