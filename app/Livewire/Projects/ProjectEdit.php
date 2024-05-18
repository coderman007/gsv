<?php

namespace App\Livewire\Projects;

use App\Models\CommercialPolicy;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ProjectEdit extends Component
{
    public $openEdit = false;
    public $projectId;
    public $categories;
    public $selectedCategory;
    public $project;
    public $zone;
    public $zoneOptions = [
        'Zona Caribe',
        'Zona Andina',
        'Zona Pacífica',
        'Zona de la Orinoquía',
        'Zona de la Amazonía'
    ];
    public $kilowatts_to_provide;
    public $required_area = 0;
    public $totalProjectCost = 0;

    // Políticas comerciales
    public $internalCommissions;
    public $externalCommissions;
    public $margin;
    public $discount;

    //Resources properties
    public $showResource = '';
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
    public $selectedAdditionals;
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
    public $selectedAdditionalQuantity;
    public $selectedAdditionalEfficiencies;


    // Validation rules
    protected $rules = [
        'selectedCategory' => 'required|exists:project_categories,id',
        'zone' => 'required|in:Zona Caribe,Zona Andina,Zona Pacífica,Zona de la Orinoquía,Zona de la Amazonía',
        'kilowatts_to_provide' => 'required|numeric|min:0',
        'required_area' => 'required'
    ];

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->projectId = $project->id;
        $this->categories = ProjectCategory::pluck('name', 'id')->toArray();

        // Set project data
        $this->selectedCategory = $project->project_category_id;
        $this->zone = $project->zone;
        $this->kilowatts_to_provide = $project->kilowatts_to_provide;
        // Set other project data...

        // Cargar políticas comerciales
        $this->internalCommissions = CommercialPolicy::where('name', 'like', 'internal_commissions')->first()?->percentage ?? 0;
        $this->externalCommissions = CommercialPolicy::where('name', 'like', 'external_commissions')->first()?->percentage ?? 0;
        $this->margin = CommercialPolicy::where('name', 'like', 'margin')->first()?->percentage ?? 0;
        $this->discount = CommercialPolicy::where('name', 'like', 'discount')->first()?->percentage ?? 0;

        // Initialize selected resources arrays
        $this->selectedPositions = [];
        $this->selectedMaterials = [];
        $this->selectedTools = [];
        $this->selectedTransports = [];
        $this->selectedAdditionals = [];
        // Initialize selected resource quantities and required days
        $this->selectedPositionQuantity = 0;
        $this->selectedPositionRequiredDays = 0;
        $this->selectedMaterialQuantity = 0;
        $this->selectedToolQuantity = 0;
        $this->selectedToolRequiredDays = 0;
        $this->selectedTransportQuantity = 0;
        $this->selectedTransportRequiredDays = 0;
        $this->selectedAdditionalQuantity = 0;

        // Calculate initial values...
    }

    public function updated($name, $value): void
    {
        if (in_array($name, [
            'totalLaborCost',
            'totalMaterialCost',
            'totalToolCost',
            'totalTransportCost',
            'totalAdditional'
        ])) {
            $this->calculateTotalProjectCost();
        }
    }

    // Agrega métodos para manejar eventos, cálculos y guardar los datos actualizados del proyecto

    public function calculateHandToolCost(): void
    {
        $this->extraHandToolCost = $this->totalLaborCost * 0.05;  // 5% del costo de la mano de obra
        $this->handToolCost = $this->extraHandToolCost;  // Puedes incluir más cálculos si es necesario
    }

    public function calculateTotalProjectCost(): void
    {
        // Calcula el costo total del proyecto, incluyendo políticas comerciales
        // Calcular el costo de la herramienta de mano
        $this->calculateHandToolCost();

        // Calcular el costo total de los recursos incluyendo la herramienta de mano
        $totalResourceCost = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->handToolCost +  // Incluir el costo de la herramienta de mano
            $this->totalTransportCost +
            $this->totalAdditionalCost;

        // Aplicar políticas comerciales
        $internalCommissions = $totalResourceCost * ($this->internalCommissions / 100);
        $externalCommissions = $totalResourceCost * ($this->externalCommissions / 100);
        $margin = $totalResourceCost * ($this->margin / 100);
        $discount = $totalResourceCost * ($this->discount / 100);

        // Calcular el costo total del proyecto, incluyendo políticas comerciales
        $this->totalProjectCost = $totalResourceCost + $internalCommissions + $externalCommissions + $margin - $discount;
    }

    public function updatedKilowattsToProvide($value): void
    {
        // Actualiza el área necesaria cuando se modifica la potencia
        // Verificar que el valor es numérico y mayor o igual a cero
        if (is_numeric($value) && $value >= 0) {
            // Calcular el área necesaria si el valor es válido
            $this->required_area = number_format(($value / 0.55 * (2.6 * 1.1)),  2);

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

    public function updateProject(): void
    {
        // Definir el valor del costo estándar de herramientas
        $standardToolCost = $this->calculateStandardToolCost();  // Método para calcular este valor

        // Calcular el costo total del proyecto
        $totalCost = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->totalTransportCost +
            $this->totalAdditionalCost;

        // Obtener valores para las políticas comerciales
        $internalCommissions = $totalCost * ($this->internalCommissions / 100);
        $externalCommissions = $totalCost * ($this->externalCommissions / 100);
        $margin = $totalCost * ($this->margin / 100);
        $discount = $totalCost * ($this->discount / 100);

        // Calcular el valor de venta usando las políticas comerciales
        $saleValue = $totalCost + $internalCommissions + $externalCommissions + $margin - $discount;

        // Guarda los datos actualizados del proyecto
        $isUpdated = $this->project->update([
            'project_category_id' => $this->selectedCategory,
            'zone' => $this->zone,
            'kilowatts_to_provide' => $this->kilowatts_to_provide,
            'standard_tool_cost' => $standardToolCost,
            'total' => $totalCost,
            'sale_value' => $saleValue,
        ]);

        // Verifica si la actualización fue exitosa
        if ($isUpdated) {
            // Recarga el modelo actualizado desde la base de datos
            $project = $this->project->refresh();

            // Asocia las posiciones y actualiza los costos en la tabla pivote 'position_project'
            foreach ($this->selectedPositions as $positionId) {
                $project->positions()->attach($positionId, [
                    'quantity' => $this->selectedPositionQuantity[$positionId],
                    'required_days' => $this->selectedPositionRequiredDays[$positionId],
                    'efficiency' => $this->selectedPositionEfficiencies[$positionId],
                    'total_cost' => $this->totalLaborCost,
                ]);
            }

            // Asocia los materiales y actualiza los costos en la tabla pivote 'material_project'
            foreach ($this->selectedMaterials as $materialId) {
                $project->materials()->attach($materialId, [
                    'quantity' => $this->selectedMaterialQuantity[$materialId],
                    'efficiency' => $this->selectedMaterialEfficiencies[$materialId],
                    'total_cost' => $this->totalMaterialCost,
                ]);
            }

            // Asocia herramientas y actualiza los costos en la tabla pivote 'project_tool'
            foreach ($this->selectedTools as $toolId) {
                $project->tools()->attach($toolId, [
                    'quantity' => $this->selectedToolQuantity[$toolId],
                    'required_days' => $this->selectedToolRequiredDays[$toolId],
                    'efficiency' => $this->selectedToolEfficiencies[$toolId],
                    'total_cost' => $this->totalToolCost,
                ]);
            }

            // Asocia transporte y actualiza los costos en la tabla pivote 'project_transport'
            foreach ($this->selectedTransports as $transportId) {
                $project->transports()->attach($transportId, [
                    'quantity' => $this->selectedTransportQuantity[$transportId],
                    'required_days' => $this->selectedTransportRequiredDays[$transportId],
                    'efficiency' => $this->selectedTransportEfficiencies[$transportId],
                    'total_cost' => $this->totalTransportCost,
                ]);
            }

            // Asocia costos adicionales y actualiza los costos en la tabla pivote 'additional_cost_project'
            foreach ($this->selectedAdditionals as $additionalId) {
                $project->additionals()->attach($additionalId, [
                    'quantity' => $this->selectedAdditionalQuantity[$additionalId],
                    'efficiency' => $this->selectedAdditionalEfficiencies[$additionalId],
                    'total_cost' => $this->totalAdditionalCost,
                ]);
            }

            // Calcular el costo total del proyecto después de guardar
            $this->calculateTotalProjectCost();

            // Redirige o muestra un mensaje de éxito
            $this->openEdit = false;
            $this->dispatch('updatedProject', $project);
            $this->dispatch('updatedProjectNotification');
        }
    }


    public function showLaborForm(): void
    {
        // Muestra el formulario de mano de obra
        $this->showResource = 'labor';
    }

    public function showMaterialsForm(): void
    {
        // Muestra el formulario de materiales
        $this->showResource ='materials';
    }

    public function showToolsForm(): void
    {
        // Muestra el formulario de herramientas
        $this->showResource = 'tools';
    }

    public function showTransportForm(): void
    {
        // Muestra el formulario de transporte
        $this->showResource = 'transport';
    }

    public function showAdditionalForm(): void
    {
        // Muestra el formulario de costos adicionales
        $this->showResource = 'additionals';
    }

    #[On('positionSelectionUpdated')]
    public function handlePositionSelectionUpdated($data): void
    {
        // Maneja la actualización de selección de posiciones
        $this->selectedPositions = $data['selectedPositions'];
        $this->selectedPositionQuantity = $data['positionQuantities'];
        $this->selectedPositionRequiredDays = $data['positionRequiredDays'];
        $this->selectedPositionEfficiencies = $data['positionEfficiencies'];
        $this->totalLaborCost = $data['totalLaborCost'];
        $this->calculateHandToolCost();
        $this->calculateTotalProjectCost();
        $this->showResource = '';
    }

// Agrega otros métodos para manejar la actualización de selección de materiales, herramientas, transporte y costos adicionales

    #[On('materialSelectionUpdated')]
    public function handleMaterialSelectionUpdated($data): void
    {
        // Maneja la actualización de selección de materiales
        $this->selectedMaterials = $data['selectedMaterials'];
        $this->selectedMaterialQuantity = $data['materialQuantities'];
        $this->selectedMaterialEfficiencies = $data['materialEfficiencies'];
        $this->totalMaterialCost = $data['totalMaterialCost'];
        $this->calculateTotalProjectCost();
        $this->showResource = '';
    }
    #[On('toolSelectionUpdated')]
    public function handleToolSelectionUpdated($data): void
    {
        // Maneja la actualización de selección de herramientas
        $this->selectedTools = $data['selectedTools'];
        $this->selectedToolQuantity = $data['toolQuantities'];
        $this->selectedToolRequiredDays = $data['toolRequiredDays'];
        $this->selectedToolEfficiencies = $data['toolEfficiencies'];
        $this->totalToolCost = $data['totalToolCost'];
        $this->calculateTotalProjectCost();
        $this->showResource = '';
    }
    #[On('transportSelectionUpdated')]
    public function handleTransportSelectionUpdated($data): void
    {
        // Maneja la actualización de selección de transporte
        $this->selectedTransports = $data['selectedTransports'];
        $this->selectedTransportQuantity = $data['transportQuantities'];
        $this->selectedTransportRequiredDays = $data['transportRequiredDays'];
        $this->selectedTransportEfficiencies = $data['transportEfficiencies'];
        $this->totalTransportCost = $data['totalTransportCost'];
        $this->calculateTotalProjectCost();
        $this->showResource = '';
    }
    #[On('additionalSelectionUpdated')]
    public function handleAdditionalSelectionUpdated($data): void
    {
        // Maneja la actualización de selección de costos adicionales
        $this->selectedAdditionals = $data['selectedAdditionals'];
        $this->selectedAdditionalQuantity = $data['additionalQuantities'];
        $this->selectedAdditionalEfficiencies = $data['additionalEfficiencies'];
        $this->totalAdditionalCost = $data['totalAdditionalCost'];
        $this->calculateTotalProjectCost();
        $this->showResource = '';
    }

    #[On('hideResourceForm')]
    public function hideResourceForm(): void
    {
        // Oculta el formulario de recursos
    }


    public function render(): View
    {
        // Render the view with the data
        return view('livewire.projects.project-edit', [
            'totalProjectCost' => $this->totalProjectCost,
        ]);
    }
}
