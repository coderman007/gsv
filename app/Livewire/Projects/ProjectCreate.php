<?php

namespace App\Livewire\Projects;

use App\Models\Material;
use App\Models\Project;
use App\Models\Position;
use Livewire\Component;

class ProjectCreate extends Component
{
    // Propiedades del componente
    public $openCreate = false;
    public $name;
    public $description;
    public $kilowatts_to_provide;
    public $status;

    // Posiciones de Trabajo
    public $positions = [];
    public $selectedPositions = [];
    public $positionQuantities = [];
    public $positionRequiredDays = [];

    // Materiales
    public $allMaterials;
    public $searchMaterial = '';
    public $selectedMaterial;
    public $materialQuantity;
    public $totalMaterialCost;
    public $filteredMaterials;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'status' => 'required|string|in:Activo, Inactivo',
        'positions.*' => 'nullable|exists:positions,id',
        'positionQuantities.*' => 'nullable|numeric|min:0',
        'positionRequiredDays.*' => 'nullable|numeric|min:0',
        'selectedMaterial' => 'nullable|exists:materials,id',
        'materialQuantity' => 'nullable|numeric|min:0',
    ];

    // Método para guardar el proyecto
    public function saveProject()
    {
        $this->validate();

        // Verificar la existencia de los recursos seleccionados
        $this->validateSelectedResources();

        // Crear un nuevo proyecto en la base de datos
        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
            'status' => $this->status,
        ]);

        // Asociar recursos seleccionados al proyecto con cantidades y días requeridos
        foreach ($this->selectedPositions as $index => $selectedPositionId) {
            $project->positions()->attach($selectedPositionId, [
                'quantity' => $this->positionQuantities[$index],
                'required_days' => $this->positionRequiredDays[$index],
                'total_cost' => 0, // Calcular el costo total correctamente
            ]);
        }

        // Asociar materiales seleccionados al proyecto con cantidad y costo total
        if (!empty($this->selectedMaterial) && is_numeric($this->materialQuantity) && $this->materialQuantity > 0) {
            $material = Material::find($this->selectedMaterial);
            if ($material) {
                $project->materials()->attach($material->id, [
                    'quantity' => $this->materialQuantity,
                    'total_cost' => $this->totalMaterialCost,
                ]);
            }
        }

        // Resto del código para asociar herramientas, transporte, etc.

        // Redireccionar o mostrar mensaje de éxito
        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        $this->dispatch('newProjectNotification', [
            'title' => 'Success',
            'text' => 'Proyecto Creado Exitosamente!',
            'icon' => 'success'
        ]);
        $this->reset();
    }

    public function updatedSelectedMaterial()
    {
        if (!empty($this->selectedMaterial) && is_numeric($this->materialQuantity) && $this->materialQuantity > 0) {
            $material = Material::find($this->selectedMaterial);
            if ($material) {
                $this->totalMaterialCost = $material->unit_price * $this->materialQuantity;
            }
        }
    }

    public function render()
    {
        $this->allMaterials = Material::where('reference', 'like', '%' . $this->searchMaterial . '%')->get();
        $this->filteredMaterials = $this->allMaterials; // Asignar los materiales filtrados a $filteredMaterials
        $allPositions = Position::all();
        return view('livewire.projects.project-create', compact('allPositions'));
    }
}
