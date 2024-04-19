<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectCreate extends Component
{
    // Component properties
    public $openCreate = false;
    public $name;
    public $description;
    public $kilowatts_to_provide;
    public $showResource = '';
    public $totalLaborCost = 0;
    public $totalMaterialCost = 0;
    public $totalToolCost = 0;
    public $totalTransportCost = 0;
    public $project;
    public $categories;
    public $selectedCategory;
    public $selectedPositions;
    public $selectedMaterials;
    public $selectedTools;
    public $selectedTransports;
    public $selectedPositionQuantity;
    public $selectedPositionRequiredDays;
    public $selectedMaterialQuantity;
    public $selectedMaterialRequiredDays;
    public $selectedToolQuantity;
    public $selectedToolRequiredDays;
    public $selectedTransportQuantity;
    public $selectedTransportRequiredDays;

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'selectedCategory' => 'required|exists:project_categories,id',
    ];

    public function mount(): void
    {
        $this->categories = ProjectCategory::pluck('name', 'id')->toArray();
        // Initialize selected resources arrays
        $this->selectedPositions = [];
        $this->selectedMaterials = [];
        $this->selectedTools = [];
        $this->selectedTransports = [];
        // Initialize selected resource quantities and required days
        $this->selectedPositionQuantity = 0;
        $this->selectedPositionRequiredDays = 0;
        $this->selectedMaterialQuantity = 0;
        $this->selectedMaterialRequiredDays = 0;
        $this->selectedToolQuantity = 0;
        $this->selectedToolRequiredDays = 0;
        $this->selectedTransportQuantity = 0;
        $this->selectedTransportRequiredDays = 0;
    }

    // Method to save the project
    public function saveProject(): void
    {
        $this->validate();

        // Create a new project in the database
        $project = Project::create([
            'project_category_id' => $this->selectedCategory,
            'name' => $this->name,
            'description' => $this->description,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
        ]);

        // Associate positions and update costs in the 'position_project' pivot table
        foreach ($this->selectedPositions as $positionId) {
            $project->positions()->attach($positionId, [
                'quantity' => $this->selectedPositionQuantity[$positionId],
                'required_days' => $this->selectedPositionRequiredDays[$positionId],
                'total_cost' => $this->totalLaborCost,
            ]);
        }

        // Associate materials and update costs in the 'material_project' pivot table
        foreach ($this->selectedMaterials as $materialId) {
            $project->materials()->attach($materialId, [
                'quantity' => $this->selectedMaterialQuantity[$materialId],
                'total_cost' => $this->totalMaterialCost,
            ]);
        }

        // Associate tools and update costs in the 'project_tool' pivot table
        foreach ($this->selectedTools as $toolId) {
            $project->tools()->attach($toolId, [
                'quantity' => $this->selectedToolQuantity[$toolId],
                'required_days' => $this->selectedToolRequiredDays,
                'total_cost' => $this->totalToolCost,
            ]);
        }

        // Associate transports and update costs in the 'project_transport' pivot table
        foreach ($this->selectedTransports as $transportId) {
            $project->transports()->attach($transportId, [
                'quantity' => $this->selectedTransportQuantity[$transportId],
                'required_days' => $this->selectedTransportRequiredDays[$transportId],
                'total_cost' => $this->totalTransportCost,
            ]);
        }

        // Redirect or show success message
        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        $this->dispatch('createdProjectNotification', [
            'title' => 'Success',
            'text' => 'Proyecto Creado Exitosamente!',
            'icon' => 'success'
        ]);
        $this->reset();
    }

    public function showLaborForm(): void
    {
        $this->showResource = 'labor'; // Update property based on the selected resource
    }

    public function showMaterialsForm(): void
    {
        $this->showResource = 'materials'; // Update property based on the selected resource
    }

    public function showToolsForm(): void
    {
        $this->showResource = 'tools'; // Update property based on the selected resource
    }

    public function showTransportForm(): void
    {
        $this->showResource = 'transport'; // Update property based on the selected resource
    }

    #[On('positionSelectionUpdated')]
    public function handlePositionSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedPositions = $data['selectedPositions'];
        $this->selectedPositionQuantity = $data['positionQuantities'];
        $this->selectedPositionRequiredDays = $data['positionRequiredDays'];
        $this->totalLaborCost = $data['totalLaborCost'];

        // Update the 'position_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedPositions as $positionId) {
                $this->project->positions()->syncWithoutDetaching([
                    $positionId => [
                        'quantity' => $this->selectedPositionQuantity[$positionId],
                        'required_days' => $this->selectedPositionRequiredDays[$positionId],
                        'total_cost' => $this->totalLaborCost,
                    ]
                ]);
            }
        }
    }

    #[On('materialSelectionUpdated')]
    public function handleMaterialSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedMaterials = $data['selectedMaterials'];
        $this->selectedMaterialQuantity = $data['materialQuantities'];
        $this->totalMaterialCost = $data['totalMaterialCost'];

        // Update the 'material_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedMaterials as $materialId) {
                $this->project->materials()->syncWithoutDetaching([
                    $materialId => [
                        'quantity' => $this->selectedMaterialQuantity[$materialId],
                        'total_cost' => $this->totalMaterialCost,
                    ]
                ]);
            }
        }
    }

    #[On('toolSelectionUpdated')]
    public function handleToolSelectionUpdated($data): void
    {
        // Actualizar propiedades relevantes con los datos recibidos
        $this->selectedTools = $data['selectedTools'];
        $this->selectedToolQuantity = $data['toolQuantities'];
        $this->totalToolCost = $data['totalToolCost'];

        // Actualizar los costos totales de las herramientas en la tabla pivot 'project_tool' si el proyecto ya existe
        if ($this->project) {
            foreach ($this->selectedTools as $toolId) {
                $this->project->tools()->updateExistingPivot($toolId, [
                    'quantity' => $this->selectedToolQuantity[$toolId],
                    'total_cost' => $this->totalToolCost,
                ]);
            }
        }
    }

    #[On('transportSelectionUpdated')]
    public function handleTransportSelectionUpdated($data): void
    {
        // Actualizar propiedades relevantes con los datos recibidos
        $this->selectedTransports = $data['selectedTransports'];
        $this->selectedTransportQuantity = $data['transportQuantities'];
        $this->selectedTransportRequiredDays = $data['transportRequiredDays'];
        $this->totalTransportCost = $data['totalTransportCost'];

        // Actualizar los costos totales de transporte en la tabla pivot 'project_transport' si el proyecto ya existe
        if ($this->project) {
            foreach ($this->selectedTransports as $transportId) {
                $this->project->transports()->updateExistingPivot($transportId, [
                    'quantity' => $this->selectedTransportQuantity[$transportId],
                    'required_days' => $this->selectedTransportRequiredDays[$transportId],
                    'total_cost' => $this->totalTransportCost,
                ]);
            }
        }
    }


    #[On('hideResourceForm')]  // Listen for the event
    public function hideResourceForm(): void
    {
        $this->showResource = ''; // Reset the property to hide the resource form
    }

    public function render(): View
    {
        return view('livewire.projects.project-create');
    }
}
/* #[On('totalMaterialCostUpdated')]
 public function updateTotalMaterialCost($totalMaterialCost): void
 {
     // Update the received value in ProjectCreate
     $this->totalMaterialCost = number_format($totalMaterialCost, 2);

     // Update the total cost in the 'material_project' pivot table if the project already exists
     if ($this->project) {
         $this->project->materials()->syncWithoutDetaching([
             $this->selectedMaterials => [
                 'total_cost' => $this->totalMaterialCost,
             ]
         ]);
     }
 }

 #[On('totalToolCostUpdated')]  // Listen for the event
 public function updateTotalToolCost($totalToolCost): void
 {
     // Update the received value in ProjectCreate
     $this->totalToolCost = number_format($totalToolCost, 2);

     // Update the total cost in the 'project_tool' pivot table if the project already exists
     if ($this->project) {
         $this->project->tools()->syncWithoutDetaching([
             $this->selectedTools => [
                 'total_cost' => $this->totalToolCost,
             ]
         ]);
     }
 }

 #[On('totalTransportCostUpdated')]  // Listen for the event
 public function updateTotalTransportCost($totalTransportCost): void
 {

     // Update the received value in ProjectCreate
     $this->totalTransportCost = number_format($totalTransportCost, 2);

     // Update the total cost in the 'project_transport' pivot table if the project already exists
     if ($this->project) {
         $this->project->transports()->syncWithoutDetaching([
             $this->selectedTransports => [
                 'total_cost' => $this->totalTransportCost,
             ]
         ]);
     }
 }*/


