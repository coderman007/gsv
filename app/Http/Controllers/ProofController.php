<?php

// app/Http/Controllers/ProofController.php

// app/Http/Controllers/ProofController.php

namespace App\Http\Controllers;

use App\Models\Proof;
use Illuminate\Http\Request;
use App\Events\ProofUpdated;

class ProofController extends Controller
{
    public function update(Request $request)
    {
        $nameToUpdate = 'Carlos';
        $proofsToUpdate = Proof::where('name', $nameToUpdate)->get();

        foreach ($proofsToUpdate as $proof) {
            $proof->value = 50;
            $proof->save();

            // Disparar el evento
            event(new ProofUpdated($proof));
        }

        return redirect()->route('proofs.index')->with('success', 'Los registros de Proof se han actualizado correctamente.');
    }
}
