<?php

namespace App\Livewire\Resources\Transports;

use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Component;

class TransportCreate extends Component
{

    public $openCreate = false;
    public $vehicle_type;
    public $capacity;
    public $cost_per_day;
    public $fuel_type;


    protected $rules = [
        'vehicle_type' => 'required|string', // Validar que el tipo de vehículo sea requerido y una cadena
        'capacity' => 'nullable|numeric|min:0',
        'cost_per_day' => 'required|numeric|min:0',
        'fuel_type' => 'nullable|string',
    ];

    public function createTransport(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        $transport = Transport::create([
            'vehicle_type' => $this->vehicle_type,
            'capacity' => $this->capacity ?? 0,
            'cost_per_day' => $this->cost_per_day,
            'fuel_type' => $this->fuel_type,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdTransport', $transport);
        $this->dispatch('createdTransportNotification');
    }

    public function render(): View
    {
        return view('livewire.resources.transports.transport-create');
    }
}

