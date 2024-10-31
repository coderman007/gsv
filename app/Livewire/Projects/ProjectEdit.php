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
use Livewire\WithFileUploads;

// Para manejar archivos

/**
 * @method resetProjectCreateComponent()
 */
class ProjectEdit extends Component
{
    use WithFileUploads;

    public Project $project;
    public $openEdit = false;
    public $categories;
    public $selectedCategory;
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
    public $existingPositionSelections = [];
    public $existingMaterialSelections = [];
    public $existingToolSelections = [];
    public $existingTransportSelections = [];
    public $existingAdditionalSelections = [];

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

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->existingPositionSelections = $project->positions->map(function ($position) {
            return [
                'position_id' => $position->id,
                'quantity' => $position->pivot->quantity,
                'required_days' => $position->pivot->required_days,
                'efficiency' => $position->pivot->efficiency
            ];
        })->toArray();
        $this->existingMaterialSelections = $project->materials->map(function ($material) {
            return [
                'material_id' => $material->id,
                'quantity' => $material->pivot->quantity,
                'efficiency' => $material->pivot->efficiency
            ];
        })->toArray();
        $this->existingToolSelections = $project->tools->map(function ($tool) {
            return [
                'tool_id' => $tool->id,
                'quantity' => $tool->pivot->quantity,
                'required_days' => $tool->pivot->required_days,
                'efficiency' => $tool->pivot->efficiency
            ];
        })->toArray();
        $this->existingTransportSelections = $project->transports->map(function ($transport) {
            return [
                'transport_id' => $transport->id,
                'quantity' => $transport->pivot->quantity,
                'required_days' => $transport->pivot->required_days,
                'efficiency' => $transport->pivot->efficiency
            ];
        })->toArray();
        $this->existingAdditionalSelections = $project->additionals->map(function ($additional) {
            return [
                'additional_id' => $additional->id,
                'quantity' => $additional->pivot->quantity,
                'efficiency' => $additional->pivot->efficiency
            ];
        })->toArray();

        $this->categories = ProjectCategory::pluck('name', 'id')->toArray();

        // Cargar políticas comerciales
        $this->internalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Internas')->first()?->percentage ?? 0;
        $this->externalCommissions = CommercialPolicy::where('name', 'like', 'Comisiones Externas')->first()?->percentage ?? 0;
        $this->margin = CommercialPolicy::where('name', 'like', 'Margen')->first()?->percentage ?? 0;
        $this->discount = CommercialPolicy::where('name', 'like', 'Descuento')->first()?->percentage ?? 0;


        // Load existing project data into the component properties
        $this->selectedCategory = $project->project_category_id;
        $this->zone = $project->zone;
        $this->power_output = $project->power_output;
        $this->required_area = $project->required_area;
        $this->totalLaborCost = $project->total_labor_cost;
        $this->totalMaterialCost = $project->total_material_cost;
        $this->handToolCost = $project->hand_tool_cost;
        $this->totalToolCost = $project->total_tool_cost;
        $this->totalTransportCost = $project->total_transport_cost;
        $this->totalAdditionalCost = $project->total_additional_cost;
        $this->totalProjectCost = $project->sale_value;

        // Cargar datos de recursos existentes (posiciones, materiales, etc.)
        $this->selectedPositions = $project->positions->pluck('id')->toArray();
        foreach ($project->positions as $position) {
            $this->selectedPositionQuantity[$position->id] = $position->pivot->quantity;
            $this->selectedPositionRequiredDays[$position->id] = $position->pivot->required_days;
            $this->selectedPositionEfficiencies[$position->id] = $position->pivot->efficiency;
        }

        $this->selectedMaterials = $project->materials->pluck('id')->toArray();
        foreach ($project->materials as $material) {
            $this->selectedMaterialQuantity[$material->id] = $material->pivot->quantity;
            $this->selectedMaterialEfficiencies[$material->id] = $material->pivot->efficiency;
        }

        $this->selectedTools = $project->tools->pluck('id')->toArray();
        foreach ($project->tools as $tool) {
            $this->selectedToolQuantity[$tool->id] = $tool->pivot->quantity;
            $this->selectedToolRequiredDays[$tool->id] = $tool->pivot->required_days;
            $this->selectedToolEfficiencies[$tool->id] = $tool->pivot->efficiency;
        }

        $this->selectedTransports = $project->transports->pluck('id')->toArray();
        foreach ($project->transports as $transport) {
            $this->selectedTransportQuantity[$transport->id] = $transport->pivot->quantity;
            $this->selectedTransportRequiredDays[$transport->id] = $transport->pivot->required_days;
            $this->selectedTransportEfficiencies[$transport->id] = $transport->pivot->efficiency;
        }

        $this->selectedAdditionals = $project->additionals->pluck('id')->toArray();
        foreach ($project->additionals as $additional) {
            $this->selectedAdditionalQuantity[$additional->id] = $additional->pivot->quantity;
            $this->selectedAdditionalEfficiencies[$additional->id] = $additional->pivot->efficiency;
        }

        // Calculate total costs on mount
        $this->calculateTotalProjectCost();
    }

    public function updated($name): void
    {
        if (in_array($name, [
            'totalLaborCost',
            'totalMaterialCost',
            'totalToolCost',
            'totalTransportCost',
            'totalAdditionalCost'
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
        $rawValue = $this->totalLaborCost + $this->totalMaterialCost +
            $this->totalToolCost + $this->totalTransportCost +
            $this->totalAdditionalCost + $handToolCost;

        // Aplicar políticas comerciales
        $internalCommissions = $this->internalCommissions / 100;
        $externalCommissions = $this->externalCommissions / 100;
        $margin = $this->margin / 100;
        $discount = $this->discount / 100;

        // Calcular el precio de venta del proyecto utilizando la fórmula correcta
        $denominator = (1 - $margin - $internalCommissions - $externalCommissions) * (1 - $discount);

        if ($denominator > 0) {
            $saleValue = $rawValue / $denominator;
        } else {
            $saleValue = 0;
        }

        $this->totalProjectCost = $saleValue;

    }

    // Actualizar área necesaria cuando se modifica la potencia
    public function updatedPowerOutput($value): void
    {
        // Verificar que el valor es numérico y mayor o igual a cero
        if (is_numeric($value) && $value >= 0) {
            // Calcular el área necesaria si el valor es válido
            $this->required_area = number_format(($value / 0.55 * (2.6 * 1.1)), 2);

            // Limpiar el error si existe
            $this->resetErrorBag('power_output'); // Elimina el mensaje de error
        } else {
            // Si el valor no es válido, restablece el área necesaria y emite un error de validación
            $this->required_area = null;

            // Generar un mensaje de error
            $this->addError('power_output', 'Debe ingresar un número válido de kilovatios.');
        }
    }

    public function updateProject(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

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

        // Calcular el precio de venta del proyecto utilizando la fórmula correcta
        $denominator = (1 - $margin - $internalCommissions - $externalCommissions) * (1 - $discount);

        // Verificar que el denominador no sea cero o negativo para evitar divisiones por cero o resultados negativos
        if ($denominator > 0) {
            $saleValue = $rawValue / $denominator;

//            dd($saleValue);
        } else {
            $saleValue = 0; // O manejar el error apropiadamente

        }

        // Update the project
        $this->project->update([
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

        // Sync or update pivot table data
        $this->project->positions()->sync($this->getPositionSyncData());
        $this->project->materials()->sync($this->getMaterialSyncData());
        $this->project->tools()->sync($this->getToolSyncData());
        $this->project->transports()->sync($this->getTransportSyncData());
        $this->project->additionals()->sync($this->getAdditionalSyncData());

        $this->openEdit = false;
        $this->dispatch('updatedProject', $this->project);
        $this->dispatch('updatedProjectNotification');
        $this->dispatch('resetProjectCreateComponent');
        $this->dispatch('reloadPage');  // Despachar evento para recargar la página
    }

// Helper methods to prepare data for syncing pivot tables
    private function getPositionSyncData(): array
    {
        $syncData = [];
        foreach ($this->selectedPositions as $positionId) {
            $position = Position::find($positionId);

            // Obtener la eficiencia; si no está definida, usar 1 por defecto
            $efficiency = $this->selectedPositionEfficiencies[$positionId] ?? 1;

            $totalCost = $this->selectedPositionQuantity[$positionId] *
                $this->selectedPositionRequiredDays[$positionId] *
                $efficiency *
                $position->real_daily_cost;

            $syncData[$positionId] = [
                'quantity' => $this->selectedPositionQuantity[$positionId],
                'required_days' => $this->selectedPositionRequiredDays[$positionId],
                'efficiency' => $efficiency, // Asignar eficiencia (1 por defecto si no está definida)
                'total_cost' => $totalCost, // Agregar el costo total
            ];
        }
        return $syncData;
    }


    private function getMaterialSyncData(): array
    {
        $syncData = [];
        foreach ($this->selectedMaterials as $materialId) {
            $material = Material::find($materialId);

            // Obtener la eficiencia; si no está definida, usar 1 por defecto
            $efficiency = $this->selectedMaterialEfficiencies[$materialId] ?? 1;

            $totalCost = $this->selectedMaterialQuantity[$materialId] *
                $efficiency *
                $material->unit_price;

            $syncData[$materialId] = [
                'quantity' => $this->selectedMaterialQuantity[$materialId],
                'efficiency' => $efficiency, // Asignar eficiencia (1 por defecto si no está definida)
                'total_cost' => $totalCost, // Agregar el costo total
            ];
        }
        return $syncData;
    }


    private function getToolSyncData(): array
    {
        $syncData = [];
        foreach ($this->selectedTools as $toolId) {
            $tool = Tool::find($toolId);

            // Obtener la eficiencia; si no está definida, usar 1 por defecto
            $efficiency = $this->selectedToolEfficiencies[$toolId] ?? 1;

            $totalCost = $this->selectedToolQuantity[$toolId] *
                $this->selectedToolRequiredDays[$toolId] *
                $efficiency *
                $tool->unit_price_per_day;

            $syncData[$toolId] = [
                'quantity' => $this->selectedToolQuantity[$toolId],
                'required_days' => $this->selectedToolRequiredDays[$toolId],
                'efficiency' => $efficiency, // Asignar eficiencia (1 por defecto si no está definida)
                'total_cost' => $totalCost, // Agregar el costo total
            ];
        }
        return $syncData;
    }


    private function getTransportSyncData(): array
    {
        $syncData = [];
        foreach ($this->selectedTransports as $transportId) {
            $transport = Transport::find($transportId);

            // Obtener la eficiencia; si no está definida, usar 1 por defecto
            $efficiency = $this->selectedTransportEfficiencies[$transportId] ?? 1;

            $totalCost = $this->selectedTransportQuantity[$transportId] *
                $this->selectedTransportRequiredDays[$transportId] *
                $efficiency *
                $transport->cost_per_day;

            $syncData[$transportId] = [
                'quantity' => $this->selectedTransportQuantity[$transportId],
                'required_days' => $this->selectedTransportRequiredDays[$transportId],
                'efficiency' => $efficiency, // Asignar eficiencia (1 por defecto si no está definida)
                'total_cost' => $totalCost, // Agregar el costo total
            ];
        }
        return $syncData;
    }


    private function getAdditionalSyncData(): array
    {
        $syncData = [];
        foreach ($this->selectedAdditionals as $additionalId) {
            $additional = Additional::find($additionalId);

            // Obtener la eficiencia; si no está definida, usar 1 por defecto
            $efficiency = $this->selectedAdditionalEfficiencies[$additionalId] ?? 1;

            $totalCost = $this->selectedAdditionalQuantity[$additionalId] *
                $efficiency *
                $additional->unit_price;

            $syncData[$additionalId] = [
                'quantity' => $this->selectedAdditionalQuantity[$additionalId],
                'efficiency' => $efficiency, // Asignar eficiencia (1 por defecto si no está definida)
                'total_cost' => $totalCost, // Agregar el costo total
            ];
        }
        return $syncData;
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

    #[On('positionSelectionEditUpdated')]
    public function handlePositionSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedPositions = $data['selectedPositionsEdit'];
        $this->selectedPositionQuantity = $data['positionQuantitiesEdit'];
        $this->selectedPositionRequiredDays = $data['positionRequiredDaysEdit'];
        $this->selectedPositionEfficiencies = $data['positionEfficienciesEdit'];
        $this->totalLaborCost = $data['totalLaborCostEdit'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('materialSelectionEditUpdated')]
    public function handleMaterialSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedMaterials = $data['selectedMaterialsEdit'];
        $this->selectedMaterialQuantity = $data['materialQuantitiesEdit'];
        $this->selectedMaterialEfficiencies = $data['materialEfficienciesEdit'];
        $this->totalMaterialCost = $data['totalMaterialCostEdit'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('toolSelectionEditUpdated')]
    public function handleToolSelectionUpdated($data): void
    {
        $this->selectedTools = $data['selectedToolsEdit'];
        $this->selectedToolQuantity = $data['toolQuantitiesEdit'];
        $this->selectedToolRequiredDays = $data['toolRequiredDaysEdit']; // Actualizar días requeridos
        $this->selectedToolEfficiencies = $data['toolEfficienciesEdit'];
        $this->totalToolCost = $data['totalToolCostEdit'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('transportSelectionEditUpdated')]
    public function handleTransportSelectionUpdated($data): void
    {
        // Actualizar propiedades relevantes con los datos recibidos
        $this->selectedTransports = $data['selectedTransportsEdit'];
        $this->selectedTransportQuantity = $data['transportQuantitiesEdit'];
        $this->selectedTransportRequiredDays = $data['transportRequiredDaysEdit'];
        $this->selectedTransportEfficiencies = $data['transportEfficienciesEdit'];
        $this->totalTransportCost = $data['totalTransportCostEdit'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('additionalSelectionEditUpdated')]
    public function handleAdditionalSelectionUpdated($data): void
    {
        // Update relevant properties with received data
        $this->selectedAdditionals = $data['selectedAdditionalsEdit'];
        $this->selectedAdditionalQuantity = $data['additionalQuantitiesEdit'];
        $this->selectedAdditionalEfficiencies = $data['additionalEfficienciesEdit'];
        $this->totalAdditionalCost = $data['totalAdditionalCostEdit'];

        $this->calculateTotalProjectCost(); // Recalcular el costo total
    }

    #[On('hideResourceFormEdit')]  // Listen for the event
    public function hideResourceForm(): void
    {
        $this->showResource = '';
    }

    public function render(): View
    {
        return view('livewire.projects.project-edit');
    }
}
