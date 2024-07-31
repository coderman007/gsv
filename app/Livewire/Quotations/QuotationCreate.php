<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Material; // Importar el modelo Material
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

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
    public $panels_needed; // Nueva propiedad para el número de paneles requeridos

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

        $this->project = Project::where('power_output', '>=', $requiredPowerOutput)->first();

        if (!$this->project) {
            $this->addError('energy_to_provide', 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.');
            return;
        }

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
        $requiredPowerOutput = ($this->energy_to_provide / 30) / $this->solar_radiation_level;

        $project = Project::where('power_output', '>=', $requiredPowerOutput)
            ->orderBy('power_output')
            ->first();

        $this->project = $project;
        if ($project) {
            $this->projectName = $project->projectCategory->name . " de " . $project->power_output . " kW.";
            $this->required_area = $project->required_area;
            $this->subtotal = $project->raw_value;
            $this->total = $project->sale_value;

            // Buscar el material con referencia 'Módulo Solar'
            $material = Material::where('reference', 'Módulo Solar')->first();
            if ($material) {
                $panelPower = $material->description; // Aquí, 'description' contiene la potencia del panel
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
