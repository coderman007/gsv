<?php

namespace App\Livewire\Projects;

use App\Models\Additional;
use App\Models\CommercialPolicy;
use App\Models\Material;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Tool;
use App\Models\Transport;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property null $propertyName
 */
class ProjectCreate extends Component
{
    public $openCreate = false;
    public $categories;
    public $selectedCategory;
    public $project;
    public $zone;
    public $zoneOptions = [
        'Medellin y Municipios Cercanos',
        'Antioquia Cercana',
        'Antioquia Lejana',
        'Caribe',
        'Urabá',
        'Centro',
        'Valle'
    ];
    public $power_output;
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
        'zone' => 'required|in:Medellin y Municipios Cercanos,Antioquia Cercana,Antioquia Lejana,Caribe,Urabá,Centro,Valle',
        'power_output' => 'required|numeric|min:0',
        'required_area' => 'required|numeric|min:0',
    ];

    // Validation messages
    protected $messages = [
        'selectedCategory.required' => 'Debe seleccionar una categoría de proyecto.',
        'selectedCategory.exists' => 'La categoría seleccionada no es válida.',
        'zone.required' => 'Debe seleccionar una zona.',
        'zone.in' => 'La zona seleccionada no es válida.',
        'power_output.required' => 'Debe ingresar la potencia del proyecto.',
        'power_output.numeric' => 'La potencia debe ser un número.',
        'power_output.min' => 'La potencia no puede ser negativa.',
        'required_area.required' => 'Debe ingresar el area necesaria del proyecto.',
        'required_area.numeric' => 'El area necesaria debe ser un número.',
        'required_area.min' => 'El area necesaria no puede ser negativa.',
    ];

    public function mount(): void
    {
        $this->categories = ProjectCategory::pluck('name', 'id')->toArray();

        // Cargar políticas comerciales
        $this->internalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Internas')->first()?->percentage ?? 0;
        $this->externalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Externas')->first()?->percentage ?? 0;
        $this->margin = CommercialPolicy::where('name', 'like', 'Margen')->first()?->percentage ?? 0;
        $this->discount = CommercialPolicy::where('name', 'like', 'Descuento')->first()?->percentage ?? 0;

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
    }
    public function updated($name): void
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
    public function calculateHandToolCost(): float
    {
        $this->extraHandToolCost = $this->totalLaborCost * 0.05;  // 5% del costo de la mano de obra
        $this->handToolCost = $this->extraHandToolCost;  // Puedes incluir más cálculos si es necesario

        return $this->handToolCost;
    }

    // Método para calcular el costo total del proyecto, incluyendo políticas comerciales
    public function calculateTotalProjectCost(): void
    {
        $handToolCost = $this->calculateHandToolCost();

        // Calcular el costo total de los recursos incluyendo la herramienta de mano
        $totalResourceCost = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->totalTransportCost + $this->totalAdditionalCost +
            $handToolCost; // Incluir el costo de la herramienta de mano

        // Aplicar políticas comerciales
        $internalCommissions = $this->internalCommissions / 100;
        $externalCommissions = $this->externalCommissions / 100;
        $margin = $this->margin / 100;
        $discount = $this->discount / 100;

        // Calcular el precio de venta del proyecto utilizando la fórmula correcta
        $denominator = (1 - $margin - $internalCommissions - $externalCommissions) * (1 - $discount);

        // Verificar que el denominador no sea cero o negativo para evitar divisiones por cero o resultados negativos
        if ($denominator > 0) {
            $this->totalProjectCost = $totalResourceCost / $denominator;
        } else {
            $this->totalProjectCost = 0; // O manejar el error apropiadamente
        }
    }


    // Actualizar área necesaria cuando se modifica la potencia
    public function updatedPowerOutput($value): void
    {
        // Verificar que el valor es numérico y mayor o igual a cero
        if (is_numeric($value) && $value >= 0) {
            // Calcular el área necesaria si el valor es válido
            $this->required_area = number_format(($value / 0.55 * (2.6 * 1.1)),  2);

            // Limpiar el error si existe
            $this->resetErrorBag('power_output'); // Elimina el mensaje de error
        } else {
            // Si el valor no es válido, restablece el área necesaria y emite un error de validación
            $this->required_area = null;

            // Generar un mensaje de error
            $this->addError('power_output', 'Debe ingresar un número válido de kilovatios.');
        }
    }

    // Method to save the project
    public function saveProject(): void
    {
        $this->validate();

        // Calcular el costo de las herramientas de mano
        $handToolCost = $this->calculateHandToolCost();

        // Calcular el valor bruto incluyendo el costo de herramientas de mano
        $rawValue = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->totalTransportCost +
            $this->totalAdditionalCost + $handToolCost;

        // Obtener valores para las políticas comerciales
        $internalCommissions = $this->internalCommissions / 100;
        $externalCommissions = $this->externalCommissions / 100;
        $margin = $this->margin / 100;
        $discount = $this->discount / 100;

        $policies = [
            $internalCommissions,
            $externalCommissions,
            $margin,
            $discount
        ];

        // Calcular el precio de venta del proyecto utilizando la fórmula correcta
        $denominator = (1 - $margin - $internalCommissions - $externalCommissions) * (1 - $discount);

        // Verificar que el denominador no sea cero o negativo para evitar divisiones por cero o resultados negativos
        if ($denominator > 0) {
            $saleValue = $rawValue / $denominator;
        } else {
            $saleValue = 0; // O manejar el error apropiadamente
        }

        // Crear el proyecto con el valor de venta calculado
        $project = Project::create([
            'project_category_id' => $this->selectedCategory,
            'zone' => $this->zone,
            'power_output' => $this->power_output,
            'required_area' => $this->required_area,
            'hand_tool_cost' => $handToolCost,
            'raw_value' => $rawValue,
            'sale_value' => $saleValue,
            'total_labor_cost' => $this->totalLaborCost,
            'total_tool_cost' => $this->totalToolCost,
            'total_material_cost' => $this->totalMaterialCost,
            'total_transport_cost' => $this->totalTransportCost,
            'total_additional_cost' => $this->totalAdditionalCost,
        ]);

        // Associate positions and update costs in the 'position_project' pivot table
        foreach ($this->selectedPositions as $positionId) {
            $quantity = $this->selectedPositionQuantity[$positionId] ?? 0;
            $requiredDays = $this->selectedPositionRequiredDays[$positionId] ?? 0;
            $efficiency = $this->selectedPositionEfficiencies[$positionId] ?? 1; // Valor por defecto
            $position = Position::find($positionId);

            $totalCost = $quantity * $requiredDays * $efficiency * $position->real_daily_cost;

            $project->positions()->attach($positionId, [
                'quantity' => $quantity,
                'required_days' => $requiredDays,
                'efficiency' => $efficiency,
                'total_cost' => $totalCost,
            ]);
        }

        // Associate materials and update costs in the 'material_project' pivot table
        foreach ($this->selectedMaterials as $materialId) {
            $quantity = $this->selectedMaterialQuantity[$materialId] ?? 0;
            $efficiency = $this->selectedMaterialEfficiencies[$materialId] ?? 1; // Valor por defecto
            $material = Material::find($materialId);

            $totalCost = $quantity * $efficiency * $material->unit_price;

            $project->materials()->attach($materialId, [
                'quantity' => $quantity,
                'efficiency' => $efficiency,
                'total_cost' => $totalCost,
            ]);
        }

        // Associate tools and update costs in the 'project_tool' pivot table
        foreach ($this->selectedTools as $toolId) {
            $quantity = $this->selectedToolQuantity[$toolId] ?? 0;
            $requiredDays = $this->selectedToolRequiredDays[$toolId] ?? 0;
            $efficiency = $this->selectedToolEfficiencies[$toolId] ?? 1; // Valor por defecto
            $tool = Tool::find($toolId);

            $totalCost = $quantity * $requiredDays * $efficiency * $tool->unit_price_per_day;

            $project->tools()->attach($toolId, [
                'quantity' => $quantity,
                'required_days' => $requiredDays,
                'efficiency' => $efficiency,
                'total_cost' => $totalCost,
            ]);
        }

        // Associate transports and update costs in the 'project_transport' pivot table
        foreach ($this->selectedTransports as $transportId) {
            $quantity = $this->selectedTransportQuantity[$transportId] ?? 0;
            $requiredDays = $this->selectedTransportRequiredDays[$transportId] ?? 0;
            $efficiency = $this->selectedTransportEfficiencies[$transportId] ?? 1; // Valor por defecto
            $transport = Transport::find($transportId);

            $totalCost = $quantity * $requiredDays * $efficiency * $transport->cost_per_day;

            $project->transports()->attach($transportId, [
                'quantity' => $quantity,
                'required_days' => $requiredDays,
                'efficiency' => $efficiency,
                'total_cost' => $totalCost,
            ]);
        }

        // Associate additional costs and update costs in the 'additional_cost_project' pivot table
        foreach ($this->selectedAdditionals as $additionalId) {
            $quantity = $this->selectedAdditionalQuantity[$additionalId] ?? 0;
            $efficiency = $this->selectedAdditionalEfficiencies[$additionalId] ?? 1; // Valor por defecto
            $additional = Additional::find($additionalId);

            $totalCost = $quantity * $efficiency * $additional->unit_price;

            $project->additionals()->attach($additionalId, [
                'quantity' => $quantity,
                'efficiency' => $efficiency,
                'total_cost' => $totalCost,
            ]);
        }

        // Calcular el costo total del proyecto después de guardar
        $this->calculateTotalProjectCost();

        // Redirect or show success message
        $this->openCreate = false;
        $this->dispatch('createdProject', $project);
        $this->dispatch('createdProjectNotification');
        $this->dispatch('commercialPolicies', $policies);

        $this->reset();
    }

// Métodos adicionales para obtener el costo unitario de cada recurso
    protected function getPositionUnitCost($positionId) {
        // Implementar la lógica para obtener el costo unitario de una posición
    }

    protected function getMaterialUnitCost($materialId) {
        // Implementar la lógica para obtener el costo unitario de un material
    }

    protected function getToolUnitCost($toolId) {
        // Implementar la lógica para obtener el costo unitario de una herramienta
    }

    protected function getTransportUnitCost($transportId) {
        // Implementar la lógica para obtener el costo unitario de un transporte
    }

    protected function getAdditionalUnitCost($additionalId) {
        // Implementar la lógica para obtener el costo unitario de un costo adicional
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

    public function showAdditionalForm(): void
    {
        $this->showResource = 'additionals'; // Update property based on the selected resource
    }

    #[On('positionSelectionUpdated')]
    public function handlePositionSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedPositions = $data['selectedPositions'];
        $this->selectedPositionQuantity = $data['positionQuantities'];
        $this->selectedPositionRequiredDays = $data['positionRequiredDays'];
        $this->selectedPositionEfficiencies = $data['positionEfficiencies'];
        $this->totalLaborCost = $data['totalLaborCost'];

        // Update the 'position_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedPositions as $positionId) {
                $this->project->positions()->syncWithoutDetaching([
                    $positionId => [
                        'quantity' => $this->selectedPositionQuantity[$positionId],
                        'required_days' => $this->selectedPositionRequiredDays[$positionId],
                        'efficiencies' => $this->selectedPositionEfficiencies[$positionId],
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
        $this->selectedMaterialEfficiencies = $data['materialEfficiencies'];
        $this->totalMaterialCost = $data['totalMaterialCost'];

        // Update the 'material_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedMaterials as $materialId) {
                $this->project->materials()->syncWithoutDetaching([
                    $materialId => [
                        'quantity' => $this->selectedMaterialQuantity[$materialId],
                        'efficiencies' => $this->selectedMaterialEfficiencies[$materialId],
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

    #[On('additionalSelectionUpdated')]
    public function handleAdditionalSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedAdditionals = $data['selectedAdditionals'];
        $this->selectedAdditionalQuantity = $data['additionalQuantities'];
        $this->selectedAdditionalEfficiencies = $data['additionalEfficiencies'];
        $this->totalAdditionalCost = $data['totalAdditionalCost'];

        // Update the 'additional_cost_project' pivot table if the project already exists
        if ($this->project) {
            foreach ($this->selectedAdditionals as $additionalId) {
                $this->project->additionals()->syncWithoutDetaching([
                    $additionalId => [
                        'quantity' => $this->selectedAdditionalQuantity[$additionalId],
                        'efficiency' => $this->selectedAdditionalEfficiencies[$additionalId],
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
