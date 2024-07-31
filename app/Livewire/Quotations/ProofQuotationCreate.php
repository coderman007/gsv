<?php

//namespace App\Livewire\Quotations;
//
//use App\Models\Client;
//use App\Models\Project;
//use App\Models\Quotation;
//use Illuminate\View\View;
//use Livewire\Attributes\On;
//use Livewire\Component;

//class QuotationCreate extends Component
//{
//    public $openCreate = false;
//    public $clients;
//    public $city;
//    public $selectedClientId;
//    public $newClientModal = false;
//    public $project;
//    public $projectName;
//    public $consecutive; // Nueva propiedad para almacenar el consecutivo
//
//    // Datos importantes que definirán el proyecto
//    public $energy_to_provide; // Consumo promedio de energía del cliente
//    public $solar_radiation_level; // Nivel de irradiación solar (Se toma con base en la ubicación del cliente)
//    public $transformer; // Define la potencia del transformador (Monofásico/Trifásico)
//    public $roof_dimension; // Define las dimensiones de la cubierta donde se va a realizar la instalación de los paneles solares
//    public $kilowatt_cost;
//    public $quotation_date;
//    public $validity_period;
//    public $subtotal;
//    public $total;
//
//    protected $rules = [
//        'selectedClientId' => 'required|exists:clients,id',
//        'energy_to_provide' => 'required|numeric|min:0',
//        'transformer' => 'required|in:Trifásico,Monofásico',
//        'roof_dimension' => 'required|numeric|min:0',
//        'kilowatt_cost' => 'required|numeric|min:0',
//        'quotation_date' => 'required|date',
//        'validity_period' => 'required|integer|min:1',
//        'subtotal' => 'required|numeric|min:0',
//        'total' => 'required|numeric|min:0',
//    ];
//
//    public function mount(): void
//    {
//        $this->clients = Client::all();
//        $this->quotation_date = now(); // Establecer la fecha de cotización al cargar el componente
//        $this->validity_period = 30; // Establecer el período de validez predeterminado (por ejemplo, 30 días)
//        $this->generateConsecutive(); // Generar consecutivo al cargar el componente
//    }
//
//    public function createQuotation(): void
//    {
//        $this->validate();
//
//        $this->project = Project::where('power_output', '>=', $this->energy_to_provide)->first();
//
//        if (!$this->project) {
//            $this->addError('energy_to_provide', 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.');
//            return;
//        }
//
//        $quotation = Quotation::create([
//            'project_id' => $this->project->id,
//            'client_id' => $this->selectedClientId,
//            'energy_to_provide' => $this->energy_to_provide,
//            'transformer' => $this->transformer,
//            'roof_dimension' => $this->roof_dimension,
//            'kilowatt_cost' => $this->kilowatt_cost,
//            'quotation_date' => $this->quotation_date,
//            'validity_period' => $this->validity_period,
//            'subtotal' => $this->subtotal,
//            'total' => $this->total,
//            'consecutive' => $this->consecutive, // Guardar el consecutivo
//        ]);
//
//        $this->reset(['selectedClientId', 'energy_to_provide', 'project', 'transformer', 'roof_dimension', 'kilowatt_cost', 'quotation_date', 'validity_period', 'subtotal', 'total']);
//
//        $this->generateConsecutive(); // Generar un nuevo consecutivo para la siguiente cotización
//        $this->openCreate = false;
//        $this->dispatch('createdQuotation', $quotation);
//        $this->dispatch('createdQuotationNotification');
//
//    }
//
//
//    public function updatedEnergyToProvide(): void
//    {
//        $powerOutput =
//        $project = Project::where('power_output', '>=', $this->energy_to_provide)
//            ->orderBy('power_output')
//            ->first();
//
//        $this->project = $project;
//        if ($project) {
//            $this->projectName = $project->projectCategory->name . " de " . $project->power_output . " kW.";
//            $this->subtotal = $project->raw_value;
//            $this->total = $project->sale_value;
//        } else {
//            $this->subtotal = 0;
//            $this->total = 0;
//        }
//    }
//
//
//    public function createQuotation2(): void
//    {
//        $this->validate();
//
//        // Calcula la potencia del proyecto a instalar en kWp
//        $requiredPowerOutput = ($this->energy_to_provide / 30) / $this->solar_radiation_level;
//
//        // Busca un proyecto cuya salida de potencia sea mayor o igual a la potencia requerida
//        $this->project = Project::where('power_output', '>=', $requiredPowerOutput)->first();
//
//        if (!$this->project) {
//            $this->addError('energy_to_provide', 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.');
//            return;
//        }
//
//        $quotation = Quotation::create([
//            'project_id' => $this->project->id,
//            'client_id' => $this->selectedClientId,
//            'energy_to_provide' => $this->energy_to_provide,
//            'transformer' => $this->transformer,
//            'roof_dimension' => $this->roof_dimension,
//            'kilowatt_cost' => $this->kilowatt_cost,
//            'quotation_date' => $this->quotation_date,
//            'validity_period' => $this->validity_period,
//            'subtotal' => $this->subtotal,
//            'total' => $this->total,
//            'consecutive' => $this->consecutive, // Guardar el consecutivo
//        ]);
//
//        $this->reset(['selectedClientId', 'energy_to_provide', 'project', 'transformer', 'roof_dimension', 'kilowatt_cost', 'quotation_date', 'validity_period', 'subtotal', 'total']);
//
//        $this->generateConsecutive(); // Generar un nuevo consecutivo para la siguiente cotización
//        $this->openCreate = false;
//        $this->dispatch('createdQuotation', $quotation);
//        $this->dispatch('createdQuotationNotification');
//    }
//
//
//    public function updatedEnergyToProvide2(): void
//    {
//        // Calcula la potencia del proyecto a instalar en kWp
//        $requiredPowerOutput = ($this->energy_to_provide / 30) / $this->solar_radiation_level;
//
//        // Busca un proyecto cuya salida de potencia sea mayor o igual a la potencia requerida
//        $project = Project::where('power_output', '>=', $requiredPowerOutput)
//            ->orderBy('power_output')
//            ->first();
//
//        $this->project = $project;
//        if ($project) {
//            $this->projectName = $project->projectCategory->name . " de " . $project->power_output . " kW.";
//            $this->subtotal = $project->raw_value;
//            $this->total = $project->sale_value;
//        } else {
//            $this->subtotal = 0;
//            $this->total = 0;
//        }
//    }
//
//    public function showNewClientModal(): void
//    {
//        $this->newClientModal = true;
//    }
//
//    public function hideNewClientModal(): void
//    {
//        $this->newClientModal = false;
//    }
//
//    public function updateCityAndRadiation(): void
//    {
//        // Buscar el cliente seleccionado
//        $client = Client::find($this->selectedClientId);
//
//        if ($client) {
//            // Obtener la ciudad asociada
//            $city = $client->city;
//
//            if ($city) {
//                // Asignar la ciudad y el nivel de irradiancia
//                $this->city = $city->name; // Si necesitas mostrar el nombre de la ciudad
//                $this->solar_radiation_level = $city->irradiance; // Nivel de irradiancia
//            } else {
//                // Manejo de error si no se encuentra la ciudad
//                $this->addError('selectedClientId', 'El cliente seleccionado no tiene una ciudad asociada.');
//                $this->solar_radiation_level = 0; // Valor por defecto
//            }
//        }
//    }
//
//    // Método para generar el consecutivo
//    private function generateConsecutive(): void
//    {
//        // Obtener el último número de consecutivo de cotización
//        $lastQuotation = Quotation::latest()->first();
//        $consecutiveNumber = $lastQuotation ? $lastQuotation->id + 1 : 1;
//
//        // Formatear el consecutivo según el estándar deseado
//        $this->consecutive = 'PROY' . date('ymd') . '-' . str_pad($consecutiveNumber, 3, '0', STR_PAD_LEFT);
//    }
//
//    public function render(): View
//    {
//        return view('livewire.quotations.quotation-create');
//    }
//
//    #[On('clientStored')]
//    public function clientStored(): void
//    {
//        $this->clients = Client::all();
//    }
//
//    #[On('createdQuotation')]
//    public function createdQuotation($quotation): void
//    {
//        redirect()->to('quotations');
//    }
//}

