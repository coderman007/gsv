<?php

// app/Events/ProofUpdated.php

namespace App\Events;

use App\Models\Proof;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProofUpdated
{
    use Dispatchable, SerializesModels;

    public $proof;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Proof $proof)
    {
        $this->proof = $proof;
    }
}
