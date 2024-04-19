<?php

namespace App\Livewire\Projects;

use App\Models\Position;
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

        // Asociar posiciones y actualizar costos en la tabla pivote 'position_project'
        foreach ($this->selectedPositions as $positionId) {
            $project->positions()->attach($positionId, [
                'quantity' => $this->positionQuantities[$positionId],
                'required_days' => $this->positionRequiredDays[$positionId],
                'total_cost' => $this->partialCosts[$positionId],
            ]);

        }

        // Associate materials and update costs in the 'material_project' pivot table
        $project->materials()->attach($this->selectedMaterials, [
            'quantity' => $this->selectedMaterialQuantity,
            'total_cost' => $this->totalMaterialCost,
        ]);

        // Associate tools and update costs in the 'project_tool' pivot table
        $project->tools()->attach($this->selectedTools, [
            'quantity' => $this->selectedToolQuantity,
            'required_days' => $this->selectedToolRequiredDays,
            'total_cost' => $this->totalToolCost,
        ]);

        // Associate transports and update costs in the 'project_transport' pivot table
        $project->transports()->attach($this->selectedTransports, [
            'quantity' => $this->selectedTransportQuantity,
            'required_days' => $this->selectedTransportRequiredDays,
            'total_cost' => $this->totalTransportCost,
        ]);

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

    #[On('totalLaborCostUpdated')]  // Listen for the event
    public function updateTotalLaborCost($totalLaborCost): void
    {
        // Update the received value in ProjectCreate
        $this->totalLaborCost = number_format($totalLaborCost, 2);

        // Update additional fields in the 'position_project' pivot table if the project already exists
        if ($this->project) {
            $this->project->positions()->syncWithoutDetaching([
                $this->selectedPositions => [
                    'quantity' => $this->selectedPositionQuantity,
                    'required_days' => $this->selectedPositionRequiredDays,
                    'total_cost' => $this->totalLaborCost,
                ]
            ]);
        }
    }

    #[On('totalMaterialCostUpdated')]  // Listen for the event
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
