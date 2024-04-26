<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectCreate extends Component
{
    public $openCreate = false;
    public $categories;
    public $selectedCategory;
    public $project;
    public $name;
    public $zone;
    public $kilowatts_to_provide;
    public $showResource = '';

    //Resources properties
    public $totalLaborCost = 0;
    public $totalMaterialCost = 0;
    public $totalToolCost = 0;
    public $totalTransportCost = 0;
    public $totalAdditionalCost = 0;
    public $selectedPositions;
    public $selectedMaterials;
    public $selectedTools;
    public $selectedTransports;
    public $selectedAdditionalCosts;
    public $selectedPositionQuantity;
    public $selectedPositionRequiredDays;
    public $selectedMaterialQuantity;
    public $selectedToolQuantity;
    public $selectedToolRequiredDays;
    public $selectedTransportQuantity;
    public $selectedTransportRequiredDays;
    public $selectedAdditionalCostQuantity;


    // Validation rules
    protected $rules = [
        'selectedCategory' => 'required|exists:project_categories,id',
        'name' => 'required|string|max:255',
        'zone' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
    ];

    public function mount(): void
    {
        $this->categories = ProjectCategory::pluck('name', 'id')->toArray();
        // Initialize selected resources arrays
        $this->selectedPositions = [];
        $this->selectedMaterials = [];
        $this->selectedTools = [];
        $this->selectedTransports = [];
        $this->selectedAdditionalCosts = [];
        // Initialize selected resource quantities and required days
        $this->selectedPositionQuantity = 0;
        $this->selectedPositionRequiredDays = 0;
        $this->selectedMaterialQuantity = 0;
        $this->selectedToolQuantity = 0;
        $this->selectedToolRequiredDays = 0;
        $this->selectedTransportQuantity = 0;
        $this->selectedTransportRequiredDays = 0;
        $this->selectedAdditionalCostQuantity = 0;

    }

    // Method to save the project
    public function saveProject(): void
    {
        $this->validate();

        // Create a new project in the database
        $project = Project::create([
            'project_category_id' => $this->selectedCategory,
            'name' => $this->name,
            'zone' => $this->zone,
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
                'required_days' => $this->selectedToolRequiredDays[$toolId],
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

        // Associate additional costs and update costs in the 'additional_cost_project' pivot table
        foreach ($this->selectedAdditionalCosts as $additionalCostId) {
            $project->additionalCosts()->attach($additionalCostId, [
                'quantity' => $this->selectedTransportQuantity[$additionalCostId],
                'total_cost' => $this->totalAdditionalCost,
            ]);
        }

        // Redirect or show success message
        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        $this->dispatch('createdProjectNotification', [
            'title' => 'Success',
            'text' => 'APU Creado Exitosamente!',
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

    public function showAdditionalCostsForm(): void
    {
        $this->showResource = 'additionalCosts'; // Update property based on the selected resource
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
        $this->selectedTools = $data['selectedTools'];
        $this->selectedToolQuantity = $data['toolQuantities'];
        $this->selectedToolRequiredDays = $data['toolRequiredDays']; // Actualizar días requeridos
        $this->totalToolCost = $data['totalToolCost'];

        if ($this->project) {
            foreach ($this->selectedTools as $toolId) {
                $this->project->tools()->updateExistingPivot($toolId, [
                    'quantity' => $this->selectedToolQuantity[$toolId],
                    'required_days' => $this->selectedToolRequiredDays[$toolId], // Guardar días requeridos
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

    #[On('additionalCostSelectionUpdated')]
    public function handleAdditionalCostSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedAdditionalCosts = $data['selectedAdditionalCosts'];
        $this->selectedAdditionalCostQuantity = $data['additionalCostQuantities'];
        $this->totalAdditionalCost = $data['totalAdditionalCost'];

        // Update the 'additional_cost_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedAdditionalCosts as $additionalCostId) {
                $this->project->additionalCosts()->syncWithoutDetaching([
                    $additionalCostId => [
                        'quantity' => $this->selectedAdditionalCostQuantity[$additionalCostId],
                        'total_cost' => $this->totalAdditionalCost,
                    ]
                ]);
            }
        }
    }


    #[On('hideResourceForm')]  // Listen for the event
    public function hideResourceForm(): void
    {
        $this->showResource = '';
    }

    public function render(): View
    {
        return view('livewire.projects.project-create');
    }
}


