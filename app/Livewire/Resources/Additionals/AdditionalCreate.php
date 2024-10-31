<?php

namespace App\Livewire\Resources\Additionals;

use App\Models\Additional;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property mixed|null $name
 * @property mixed|null $unitPrice
 */
class AdditionalCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $name, $description, $unitPrice;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'unitPrice' => 'required|numeric|min:0',
    ];

    public function createAdditional(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        $additional = Additional::create([
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdAdditional', $additional);
        $this->dispatch('createdAdditionalNotification');

        $this->reset('name', 'description', 'unitPrice');
    }

    public function render(): View
    {
        return view('livewire.resources.additionals.additional-create');
    }
}

