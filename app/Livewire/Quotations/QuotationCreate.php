<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\Material;
use App\Models\Project;
use App\Models\Quotation;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

// Importar el modelo Material

class QuotationCreate extends Component
{
    public $openCreate = false;
    public $clients;
    public $city;
    public $selectedClientId;
    public $newClientModal = false;
    public $project;
    public $projectName;
    public $consecutive;

    public $energy_to_provide;
    public $solar_radiation_level;
    public $transformer;
    public $transformerPower;
    public $required_area;
    public $kilowatt_cost;
    public $quotation_date;
    public $validity_period;
    public $subtotal;
    public $total;
    public $panels_needed;
    public $errorMessage;

    protected $rules = [
        'selectedClientId' => 'required|exists:clients,id',
        'energy_to_provide' => 'required|numeric|min:0',
        'transformer' => 'required|in:Trifásico,Monofásico',
        'transformerPower' => 'required|numeric|min:0',
        'required_area' => 'required|numeric|min:0',
        'kilowatt_cost' => 'required|numeric|min:0',
        'quotation_date' => 'required|date',
        'validity_period' => 'required|integer|min:1',
        'subtotal' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
    ];

    public function mount(): void
    {
        $this->clients = Client::all();
        $this->quotation_date = now();
        $this->validity_period = 30;
        $this->generateConsecutive();
    }

    public function createQuotation(): void
    {
        $this->validate();

        $requiredPowerOutput = ($this->energy_to_provide / 30) / $this->solar_radiation_level;

        $project = Project::where('power_output', '>=', $requiredPowerOutput)
            ->where('power_output', '<=', $requiredPowerOutput + 2) // Limitar el margen superior a 2 kW
            ->first();

        $this->project = $project;

        if (!$this->project) {
            $this->errorMessage = 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.';
            return;
        }

        // Resetear el mensaje de error si se encuentra un proyecto
        $this->errorMessage = null;

        $quotation = Quotation::create([
            'project_id' => $this->project->id,
            'client_id' => $this->selectedClientId,
            'consecutive' => $this->consecutive,
            'energy_to_provide' => $this->energy_to_provide,
            'transformer' => $this->transformer,
            'transformer_power' => $this->transformerPower,
            'required_area' => $this->required_area,
            'panels_needed' => $this->panels_needed,
            'kilowatt_cost' => $this->kilowatt_cost,
            'quotation_date' => $this->quotation_date,
            'validity_period' => $this->validity_period,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);

        $this->reset(['selectedClientId', 'energy_to_provide', 'project', 'transformer', 'transformerPower', 'required_area', 'panels_needed', 'kilowatt_cost', 'quotation_date', 'validity_period', 'subtotal', 'total']);

        $this->generateConsecutive();
        $this->openCreate = false;
        $this->dispatch('createdQuotation', $quotation);
        $this->dispatch('createdQuotationNotification');
    }

    public function updatedEnergyToProvide(): void
    {
        if (is_null($this->selectedClientId)) {
            $this->addError('selectedClientId', 'Debe seleccionar un cliente antes de ingresar la energía a proveer.');
            return;
        }

        // Verifica si energy_to_provide es nulo o no es un número
        if (empty($this->energy_to_provide) || !is_numeric($this->energy_to_provide)) {
            // Resetear los valores relacionados con la cotización
            $this->subtotal = 0;
            $this->total = 0;
            $this->project = null;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        if ($this->solar_radiation_level <= 0) {
            $this->addError('solar_radiation_level', 'El nivel de radiación solar debe ser mayor que cero. Seleccione un cliente válido para obtener este valor.');
            $this->subtotal = 0;
            $this->total = 0;
            $this->project = null;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        // Realiza los cálculos solo si energy_to_provide es un valor numérico válido
        $requiredPowerOutput = ($this->energy_to_provide / 30) / $this->solar_radiation_level;

        $project = Project::where('power_output', '>=', $requiredPowerOutput)
            ->where('power_output', '<=', $requiredPowerOutput + 2) // Limitar el margen superior a 2 kW
            ->orderBy('power_output')
            ->first();

        $this->project = $project;

        if (!$project) {
            $this->errorMessage = 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.';
        } else {
            $this->errorMessage = null; // Resetear el mensaje de error
        }

        if ($project) {
            $this->projectName = $project->projectCategory->name . " de " . $project->power_output . " kW.";
            $this->required_area = $project->required_area;
            $this->subtotal = $project->raw_value;
            $this->total = $project->sale_value;

            // Buscar el material con referencia 'Módulo Solar'
            $material = Material::where('reference', 'Módulo Solar')->first();
            if ($material) {
                $description = $material->description;

                if (is_null($description) || $description === '') {
                    $this->addError('energy_to_provide', 'La descripción del material no puede estar vacía.');
                    return;
                }

                if (!is_numeric($description)) {
                    $this->addError('energy_to_provide', 'La descripción del material debe ser un valor numérico.');
                    return;
                }

                $panelPower = (float)$description; // Convertir 'description' a un valor numérico
                $this->panels_needed = ceil($requiredPowerOutput * 1000 / $panelPower); // Número de paneles requeridos
            } else {
                $this->addError('energy_to_provide', 'No se encontró el material con referencia Módulo Solar.');
            }

        } else {
            $this->subtotal = 0;
            $this->total = 0;
        }

        $this->transformer = null;
        $this->transformerPower = null;
    }


    public function showNewClientModal(): void
    {
        $this->newClientModal = true;
    }

    public function hideNewClientModal(): void
    {
        $this->newClientModal = false;
    }

    public function updateCityAndRadiation(): void
    {
        $client = Client::find($this->selectedClientId);

        if ($client) {
            $city = $client->city;

            if ($city) {
                $this->city = $city->name;
                $this->solar_radiation_level = $city->irradiance;
            } else {
                $this->addError('selectedClientId', 'El cliente seleccionado no tiene una ciudad asociada.');
                $this->solar_radiation_level = 0;
            }
        }
    }

    private function generateConsecutive(): void
    {
        // Obtener el último número de consecutivo de cotización
        $lastQuotation = Quotation::latest()->first();
        $consecutiveNumber = $lastQuotation ? $lastQuotation->id + 1 : 1;

        // Formatear el consecutivo según el estándar deseado
        $this->consecutive = 'PROY' . date('ymd') . '-' . str_pad($consecutiveNumber, 3, '0', STR_PAD_LEFT);
    }

    // app/Http/Livewire/Quotations/QuotationCreate.php

    public function getTotalFormattedProperty(): string
    {
        return number_format($this->total, 2, '.', ',');
    }


    public function render(): View
    {
        return view('livewire.quotations.quotation-create');
    }

    #[On('clientStored')]
    public function clientStored(): void
    {
        $this->clients = Client::all();
    }

    #[On('createdQuotation')]
    public function createdQuotation($quotation): void
    {
        redirect()->to('quotations');
    }
}
