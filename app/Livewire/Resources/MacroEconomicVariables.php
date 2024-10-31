<?php

namespace App\Livewire\Resources;

use App\Models\MacroEconomicVariable;
use Illuminate\View\View;
use Livewire\Component;

class MacroEconomicVariables extends Component
{
    public $variables;
    public $name;
    public $value;
    public $unit;
    public $description;
    public $effective_date;
    public $variableId;
    public $isEditMode = false;
    public $openDeleteModal = false;
    public $variableIdToDelete;


    protected $rules = [
        'name' => 'required|string|max:255',
        'value' => 'required|numeric',
        'unit' => 'nullable|string|max:50',
        'description' => 'nullable|string|max:1000',
        'effective_date' => 'required|date',
    ];

    public function mount(): void
    {
        $this->loadVariables();
    }

    public function loadVariables(): void
    {
        $this->variables = MacroEconomicVariable::orderBy('effective_date', 'desc')->get();
    }

    public function store(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        MacroEconomicVariable::create([
            'name' => $this->name,
            'value' => $this->value,
            'unit' => $this->unit,
            'description' => $this->description,
            'effective_date' => $this->effective_date,
        ]);

        $this->resetInputFields();
        $this->loadVariables();
        // Emitir evento para notificar sobre la creación exitosa
        $this->dispatch('createdMacroEconomicVariableNotification');
    }


    public function edit($id): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $variable = MacroEconomicVariable::findOrFail($id);
        $this->variableId = $id;
        $this->name = $variable->name;
        $this->value = $variable->value;
        $this->unit = $variable->unit;
        $this->description = $variable->description;
        $this->effective_date = $variable->effective_date->format('Y-m-d');
        $this->isEditMode = true;
    }


    public function update(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        $variable = MacroEconomicVariable::findOrFail($this->variableId);
        $variable->update([
            'name' => $this->name,
            'value' => $this->value,
            'unit' => $this->unit,
            'description' => $this->description,
            'effective_date' => $this->effective_date,
        ]);

        $this->resetInputFields();
        $this->loadVariables();
        // Emitir evento para notificar sobre la actualización exitosa
        $this->dispatch('updatedMacroEconomicVariableNotification');
    }


    public function confirmDelete($id): void
    {
        $this->variableIdToDelete = $id;
        $this->openDeleteModal = true;
    }

    public function deleteVariable(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        if ($this->variableIdToDelete) {
            MacroEconomicVariable::findOrFail($this->variableIdToDelete)->delete();
            $this->loadVariables();
            $this->dispatch('deletedMacroEconomicVariableNotification');
            $this->openDeleteModal = false;
        }
    }

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->value = '';
        $this->unit = '';
        $this->description = '';
        $this->effective_date = '';
        $this->isEditMode = false;
    }

    public function render(): View
    {
        return view('livewire.resources.macro-economic-variables');
    }
}
