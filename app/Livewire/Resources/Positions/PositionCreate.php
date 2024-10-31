<?php

namespace App\Livewire\Resources\Positions;

use App\Models\Position;
use Illuminate\View\View;
use Livewire\Component;

class PositionCreate extends Component
{
    public $openCreate = false;
    public $name, $basic, $benefitFactor, $monthlyWorkHours;
    public $realMonthlyCost, $realDailyCost;
    public $step = 1;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'basic' => 'required|numeric|min:0',
        'benefitFactor' => 'required|numeric|min:0',
        'monthlyWorkHours' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'required' => 'El campo :attribute es obligatorio.',
        'name.min' => 'El nombre de la posición de trabajo debe tener al menos :min caracteres.',
        'name.max' => 'El nombre de la posición de trabajo debe tener como máximo :max caracteres.',
        'basic.numeric' => 'El salario básico debe ser un número.',
        'basic.min' => 'El salario básico debe ser mínimo :min.',
        'benefitFactor.numeric' => 'El factor de beneficio debe ser un número.',
        'benefitFactor.min' => 'El factor de beneficio debe ser mínimo :min.',
        'monthlyWorkHours.numeric' => 'Las horas mensuales de trabajo deben ser un número.',
        'monthlyWorkHours.min' => 'Las horas mensuales de trabajo deben ser mínimo :min.',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        if ($this->basic && $this->monthlyWorkHours && $this->benefitFactor) {
            // Ajustar el cálculo al proporcionado
            $this->realDailyCost = number_format((($this->basic * ($this->benefitFactor)) / $this->monthlyWorkHours) * 8, 2, '.', '');
            $this->realMonthlyCost = number_format($this->basic * ($this->benefitFactor), 2, '.', ''); // Mantener el cálculo mensual
        }
    }

    public function createPosition(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        Position::create([
            'name' => $this->name,
            'basic' => $this->basic,
            'benefit_factor' => $this->benefitFactor,
            'monthly_work_hours' => $this->monthlyWorkHours,
            'real_monthly_cost' => $this->realMonthlyCost,
            'real_daily_cost' => $this->realDailyCost,
        ]);

        $this->openCreate = false;

        $this->dispatch('createdPosition', Position::latest()->first());
        $this->dispatch('createdPositionNotification');

        $this->reset('name', 'basic', 'benefitFactor', 'monthlyWorkHours', 'realMonthlyCost', 'realDailyCost');
        $this->step = 1;
    }

    public function openCreateForm(): void
    {
        $this->resetValidation();
        $this->reset('name', 'basic', 'benefitFactor', 'monthlyWorkHours', 'realMonthlyCost', 'realDailyCost');
        $this->step = 1;
        $this->openCreate = true;
    }

    public function render(): View
    {
        return view('livewire.resources.positions.position-create');
    }
}
