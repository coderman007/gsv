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
    public $openCloseConfirmation = false;
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
    public $categoryErrorMessage;
    public $powerErrorMessage;
    public $zoneErrorMessage;

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

    public function closeForm(): void
    {
        $this->openCreate = false;
        // Olvidar variables de sesión para posiciones de trabajo
        $this->forgetSessionVariables();

        $this->dispatch('reloadPage');
    }

    public function validateSelections(): void
    {
        $this->categoryErrorMessage = $this->selectedCategory ? '' : 'Por favor, seleccione una categoría.';
        $this->powerErrorMessage = $this->power_output ? '' : 'Por favor, ingrese la potencia.';
        $this->zoneErrorMessage = $this->zone ? '' : 'Por favor, seleccione una zona.';
    }

    public function canShowResources(): bool
    {
        return $this->selectedCategory && $this->power_output && $this->zone;
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
            $this->required_area = round(($value / 0.55 * (2.6 * 1.1)), 2);

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
        $this->dispatch('reloadPage');
        $this->reset();

        // Olvidar variables de sesión para posiciones de trabajo
        $this->forgetSessionVariables();
    }

    public function showLaborForm(): void
    {
        $this->showResource = 'labor';
//        $this->validateSelections();
//        if ($this->canShowResources()) {
//            $this->showResource = 'labor'; // Update property based on the selected resource
//        }
    }

    public function showMaterialsForm(): void
    {
        $this->showResource = 'materials';
//        $this->validateSelections();
//        if ($this->canShowResources()) {
//            $this->showResource = 'materials'; // Update property based on the selected resource
//        }
    }

    public function showToolsForm(): void
    {
        $this->showResource = 'tools';
//        $this->validateSelections();
//        if ($this->canShowResources()) {
//            $this->showResource = 'tools'; // Update property based on the selected resource
//        }
    }

    public function showTransportForm(): void
    {
        $this->showResource = 'transport';
//        $this->validateSelections();
//        if ($this->canShowResources()) {
//            $this->showResource = 'transport'; // Update property based on the selected resource
//        }
    }

    public function showAdditionalForm(): void
    {
        $this->showResource = 'additionals';
//        $this->validateSelections();
//        if ($this->canShowResources()) {
//            $this->showResource = 'additionals'; // Update property based on the selected resource
//        }
    }

    #[On('positionSelectionCreateUpdated')]
    public function handlePositionSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedPositions = $data['selectedPositionsCreate'];
        $this->selectedPositionQuantity = $data['positionQuantitiesCreate'];
        $this->selectedPositionRequiredDays = $data['positionRequiredDaysCreate'];
        $this->selectedPositionEfficiencies = $data['positionEfficienciesCreate'];
        $this->totalLaborCost = $data['totalLaborCostCreate'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('materialSelectionCreateUpdated')]
    public function handleMaterialSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedMaterials = $data['selectedMaterialsCreate'];
        $this->selectedMaterialQuantity = $data['materialQuantitiesCreate'];
        $this->selectedMaterialEfficiencies = $data['materialEfficienciesCreate'];
        $this->totalMaterialCost = $data['totalMaterialCostCreate'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('toolSelectionCreateUpdated')]
    public function handleToolSelectionUpdated($data): void
    {
        $this->selectedTools = $data['selectedToolsCreate'];
        $this->selectedToolQuantity = $data['toolQuantitiesCreate'];
        $this->selectedToolRequiredDays = $data['toolRequiredDaysCreate']; // Actualizar días requeridos
        $this->selectedToolEfficiencies = $data['toolEfficienciesCreate'];
        $this->totalToolCost = $data['totalToolCostCreate'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('transportSelectionCreateUpdated')]
    public function handleTransportSelectionUpdated($data): void
    {
        // Actualizar propiedades relevantes con los datos recibidos
        $this->selectedTransports = $data['selectedTransportsCreate'];
        $this->selectedTransportQuantity = $data['transportQuantitiesCreate'];
        $this->selectedTransportRequiredDays = $data['transportRequiredDaysCreate'];
        $this->selectedTransportEfficiencies = $data['transportEfficienciesCreate'];
        $this->totalTransportCost = $data['totalTransportCostCreate'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('additionalSelectionCreateUpdated')]
    public function handleAdditionalSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedAdditionals = $data['selectedAdditionalsCreate'];
        $this->selectedAdditionalQuantity = $data['additionalQuantitiesCreate'];
        $this->selectedAdditionalEfficiencies = $data['additionalEfficienciesCreate'];
        $this->totalAdditionalCost = $data['totalAdditionalCostCreate'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('hideResourceFormCreate')]  // Listen for the event
    public function hideResourceForm(): void
    {
        $this->showResource = '';
    }


    /**
     * @return void
     */
    protected function forgetSessionVariables(): void
    {
        session()->forget('selectedPositionsCreate');
        session()->forget('quantitiesPositionCreate');
        session()->forget('requiredDaysPositionCreate');
        session()->forget('efficiencyInputsPositionCreate');
        session()->forget('efficienciesPositionCreate');
        session()->forget('partialCostsPositionCreate');
        session()->forget('totalLaborCostCreate');

        // Olvidar variables de sesión para materiales
        session()->forget('selectedMaterialsCreate');
        session()->forget('quantitiesMaterialCreate');
        session()->forget('efficiencyInputsMaterialCreate');
        session()->forget('efficienciesMaterialCreate');
        session()->forget('partialCostsMaterialCreate');
        session()->forget('totalMaterialCostCreate');

        // Olvidar variables de sesión para herramientas manuales
        session()->forget('selectedToolsCreate');
        session()->forget('quantitiesToolCreate');
        session()->forget('requiredDaysToolCreate');
        session()->forget('efficiencyInputsToolCreate');
        session()->forget('efficienciesToolCreate');
        session()->forget('partialCostsToolCreate');
        session()->forget('totalToolCostCreate');

        // Olvidar variables de sesión para transportes
        session()->forget('selectedTransportsCreate');
        session()->forget('quantitiesTransportCreate');
        session()->forget('requiredDaysTransportCreate');
        session()->forget('efficiencyInputsTransportCreate');
        session()->forget('efficienciesTransportCreate');
        session()->forget('partialCostsTransportCreate');
        session()->forget('totalTransportCostCreate');

        // Olvidar variables de sesión para adicionales
        session()->forget('selectedAdditionalsCreate');
        session()->forget('quantitiesAdditionalsCreate');
        session()->forget('efficiencyInputsAdditionalsCreate');
        session()->forget('efficienciesAdditionalsCreate');
        session()->forget('partialCostsAdditionalsCreate');
        session()->forget('totalAdditionalCostCreate');

    }

    public function render(): View
    {
        // Renderizar la vista con el costo total del proyecto
        return view('livewire.projects.project-create', [
            'totalProjectCost' => $this->totalProjectCost,
        ]);
    }
}
