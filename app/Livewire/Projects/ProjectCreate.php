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
    public $zone;
    public $kilowatts_to_provide;
    public $required_area = 0;
    public $internal_commissions = 0;
    public $external_commissions = 0;
    public $margin = 0;
    public $discount = 0;
    public $totalProjectCost = 0;
    public $showResource = '';

    //Resources properties
    public $totalLaborCost = 0;
    public $totalMaterialCost = 0;
    public $handToolCost = 0;
    public $extraHandToolCost = 0;  // 5% del costo de mano de obra
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
    public $selectedPositionEfficiencies;
    public $selectedMaterialQuantity;
    public $selectedMaterialEfficiencies;
    public $selectedToolQuantity;
    public $selectedToolRequiredDays;
    public $selectedToolEfficiencies;

    public $selectedTransportQuantity;
    public $selectedTransportRequiredDays;
    public $selectedTransportEfficiencies;
    public $selectedAdditionalCostQuantity;


    // Validation rules
    protected $rules = [
        'selectedCategory' => 'required|exists:project_categories,id',
        'zone' => 'required|string',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'required_area' => 'required|numeric|min:0',
        'internal_commissions' => 'numeric|between:0,1',
        'external_commissions' => 'numeric|between:0,1',
        'margin' => 'numeric|between:0,1',
        'discount' => 'numeric|between:0,1',
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

    public function updated($name, $value): void
    {
        if (in_array($name, [
            'internal_commissions',
            'external_commissions',
            'margin',
            'discount',
            'totalLaborCost',
            'totalMaterialCost',
            'totalToolCost',
            'totalTransportCost',
            'totalAdditionalCost'
        ])) {
            $this->calculateTotalProjectCost();
        }
    }
    public function calculateHandToolCost(): void
    {
        $this->extraHandToolCost = $this->totalLaborCost * 0.05;  // 5% del costo de la mano de obra
        $this->handToolCost = $this->extraHandToolCost;  // Puedes incluir más cálculos si es necesario
    }

    // Método para calcular el costo total del proyecto, incluyendo políticas comerciales
    public function calculateTotalProjectCost(): void
    {
        // Calcular el costo de la herramienta de mano
        $this->calculateHandToolCost();

        // Calcular el costo total de los recursos incluyendo la herramienta de mano
        $totalResourceCost = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->handToolCost +  // Incluir el costo de la herramienta de mano
            $this->totalTransportCost +
            $this->totalAdditionalCost;

        // Aplicar políticas comerciales
        $internalCommissions = $this->internal_commissions ?? 0;
        $externalCommissions = $this->external_commissions ?? 0;
        $margin = $this->margin ?? 0;
        $discount = $this->discount ?? 0;

        // Calcular el costo total del proyecto, incluyendo políticas comerciales
        $this->totalProjectCost = $totalResourceCost / ((1 - $internalCommissions - $externalCommissions - $margin) * (1 - $discount));
    }

    // Actualizar área necesaria cuando se modifica la potencia
    public function updatedKilowattsToProvide($value): void
    {
        // Verificar que el valor es numérico y mayor o igual a cero
        if (is_numeric($value) && $value >= 0) {
            // Calcular el área necesaria si el valor es válido
            $this->required_area = number_format(($value / 0.55) * 2.6 * 1.1, 2);

            // Limpiar el error si existe
            $this->resetErrorBag('kilowatts_to_provide'); // Elimina el mensaje de error
        } else {
            // Si el valor no es válido, restablece el área necesaria y emite un error de validación
            $this->required_area = null;

            // Generar un mensaje de error
            $this->addError('kilowatts_to_provide', 'Debe ingresar un número válido de kilovatios.');
        }
    }

    public function calculateStandardToolCost(): float
    {
        // Obtiene el costo total de la mano de obra
        return $this->totalLaborCost * 0.05;
    }


    // Method to save the project
    public function saveProject(): void
    {
        $this->validate();

        // Definir el valor del costo estándar de herramientas
        $standardToolCost = $this->calculateStandardToolCost();  // Método para calcular este valor

        // Obtener valores para las políticas comerciales
        $internalCommissions = $this->internal_commissions ?? 0;  // Si no se proporciona, usa el valor por defecto
        $externalCommissions = $this->external_commissions ?? 0;
        $margin = $this->margin ?? 0;
        $discount = $this->discount ?? 0;

        // Calcular el costo total del proyecto
        $totalCost = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->totalTransportCost +
            $this->totalAdditionalCost;



        // Calcular el valor de venta usando las políticas comerciales
        $saleValue = $totalCost / ((1 - $internalCommissions -
                    $externalCommissions - $margin) *
                (1 - $discount));


        // Crear el proyecto con el valor de venta calculado
        $project = Project::create([
            'project_category_id' => $this->selectedCategory,
            'zone' => $this->zone,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
            'standard_tool_cost' => $standardToolCost,
            'required_area' => $this->required_area,
            'internal_commissions' => $internalCommissions,
            'external_commissions' => $externalCommissions,
            'margin' => $margin,
            'discount' => $discount,
            'total_cost' => $totalCost,
            'sale_value' => $saleValue,
        ]);

        // Associate positions and update costs in the 'position_project' pivot table
        foreach ($this->selectedPositions as $positionId) {
            $project->positions()->attach($positionId, [
                'quantity' => $this->selectedPositionQuantity[$positionId],
                'required_days' => $this->selectedPositionRequiredDays[$positionId],
                'efficiency' => $this->selectedPositionEfficiencies[$positionId],
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
                'efficiency' => $this->selectedToolEfficiencies[$toolId],
                'total_cost' => $this->totalToolCost,
            ]);
        }

        // Associate transports and update costs in the 'project_transport' pivot table
        foreach ($this->selectedTransports as $transportId) {
            $project->transports()->attach($transportId, [
                'quantity' => $this->selectedTransportQuantity[$transportId],
                'required_days' => $this->selectedTransportRequiredDays[$transportId],
                'efficiency' => $this->selectedTransportEfficiencies[$transportId],
                'total_cost' => $this->totalTransportCost,
            ]);
        }

        // Associate additional costs and update costs in the 'additional_cost_project' pivot table
        foreach ($this->selectedAdditionalCosts as $additionalCostId) {
            $project->additionalCosts()->attach($additionalCostId, [
                'quantity' => $this->selectedAdditionalCostQuantity[$additionalCostId],
                'total_cost' => $this->totalAdditionalCost,
            ]);
        }

        // Calcular el costo total del proyecto después de guardar
        $this->calculateTotalProjectCost();

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
        $this->selectedPositionQuantity = $data['quantities'];
        $this->selectedPositionRequiredDays = $data['requiredDays'];
        $this->selectedPositionEfficiencies = $data['efficiencies'];
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
        $this->calculateTotalProjectCost(); // Recalcular el costo total
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
        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('toolSelectionUpdated')]
    public function handleToolSelectionUpdated($data): void
    {
        $this->selectedTools = $data['selectedTools'];
        $this->selectedToolQuantity = $data['toolQuantities'];
        $this->selectedToolRequiredDays = $data['toolRequiredDays']; // Actualizar días requeridos
        $this->selectedToolEfficiencies = $data['toolEfficiencies'];
        $this->totalToolCost = $data['totalToolCost'];

        if ($this->project) {
            foreach ($this->selectedTools as $toolId) {
                $this->project->tools()->updateExistingPivot($toolId, [
                    'quantity' => $this->selectedToolQuantity[$toolId],
                    'required_days' => $this->selectedToolRequiredDays[$toolId], // Guardar días requeridos
                    'efficiency' => $this->selectedToolEfficiencies[$toolId],
                    'total_cost' => $this->totalToolCost,
                ]);
            }
        }
        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('transportSelectionUpdated')]
    public function handleTransportSelectionUpdated($data): void
    {
        // Actualizar propiedades relevantes con los datos recibidos
        $this->selectedTransports = $data['selectedTransports'];
        $this->selectedTransportQuantity = $data['transportQuantities'];
        $this->selectedTransportRequiredDays = $data['transportRequiredDays'];
        $this->selectedTransportEfficiencies = $data['transportEfficiencies'];
        $this->totalTransportCost = $data['totalTransportCost'];

        // Actualizar los costos totales de transporte en la tabla pivot 'project_transport' si el proyecto ya existe
        if ($this->project) {
            foreach ($this->selectedTransports as $transportId) {
                $this->project->transports()->updateExistingPivot($transportId, [
                    'quantity' => $this->selectedTransportQuantity[$transportId],
                    'required_days' => $this->selectedTransportRequiredDays[$transportId],
                    'efficiency' => $this->selectedTransportEfficiencies[$transportId],
                    'total_cost' => $this->totalTransportCost,
                ]);
            }
            $this->calculateTotalProjectCost(); // Recalcular el costo total
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
        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }


    #[On('hideResourceForm')]  // Listen for the event
    public function hideResourceForm(): void
    {
        $this->showResource = '';
    }

    public function render(): View
    {
        // Renderizar la vista con el costo total del proyecto
        return view('livewire.projects.project-create', [
            'totalProjectCost' => $this->totalProjectCost,
        ]);
    }
}


