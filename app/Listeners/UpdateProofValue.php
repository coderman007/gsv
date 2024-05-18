<?php

// app/Listeners/UpdateProofValue.php

namespace App\Listeners;

use App\Events\ProofUpdated;

class UpdateProofValue
{
    /**
     * Handle the event.
     *
     * @param ProofUpdated $event
     * @return void
     */
    public function handle(ProofUpdated $event): void
    {
        // Actualiza el valor del registro `Proof`
        $event->proof->value += 10; // Ejemplo: incrementar el valor en 10
        $event->proof->save();
    }
}

