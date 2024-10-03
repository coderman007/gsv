<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Material;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class QuotationEdit extends Component
{
    public $quotationId;
    public $openEdit = false;
    public $clients;
    public $city;
    public $selectedClientId;
    public $project;
    public $projectName;
    public $consecutive;

    public $energy_client;
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
        'energy_client' => 'required|numeric|min:0',
        'transformer' => 'required|in:Trifásico,Monofásico',
        'transformerPower' => 'required|numeric|min:0',
        'required_area' => 'required|numeric|min:0',
        'kilowatt_cost' => 'required|numeric|min:0',
        'quotation_date' => 'required|date',
        'validity_period' => 'required|integer|min:1',
        'subtotal' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
    ];

    public function mount($quotationId): void
    {
        $this->clients = Client::all();
        $quotation = Quotation::findOrFail($quotationId);

        $this->quotationId = $quotation->id;
        $this->selectedClientId = $quotation->client_id;
        $this->consecutive = $quotation->consecutive;
        $this->energy_client = $quotation->energy_client;
        $this->transformer = $quotation->transformer;
        $this->transformerPower = $quotation->transformer_power;
        $this->required_area = $quotation->required_area;
        $this->kilowatt_cost = $quotation->kilowatt_cost;
        $this->quotation_date = $quotation->quotation_date;
        $this->validity_period = $quotation->validity_period;
        $this->subtotal = $quotation->subtotal;
        $this->total = $quotation->total;
        $this->panels_needed = $quotation->panels_needed;

        $this->updateCityAndRadiation();
        $this->calculateQuotationData();
    }

    public function updateQuotation(): void
    {
        $this->validate();

        $quotation = Quotation::findOrFail($this->quotationId);

        $quotation->update([
            'client_id' => $this->selectedClientId,
            'energy_client' => $this->energy_client,
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

        $this->openEdit = false;
        $this->dispatch('updatedQuotation', $quotation);
        $this->dispatch('updatedQuotationNotification');
    }

    public function updatedEnergyClient(): void
    {
        $this->calculateQuotationData();
    }

    private function calculateQuotationData(): void
    {
        if (is_null($this->selectedClientId) || $this->solar_radiation_level <= 0) {
            $this->subtotal = 0;
            $this->total = 0;
            $this->project = null;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        // Cálculo de la potencia requerida
        $requiredPowerOutput = ($this->energy_client / 30) / $this->solar_radiation_level;

        // Definir un margen de tolerancia (30% en este caso)
        $tolerance = 1;
        $minPowerOutput = $requiredPowerOutput - $tolerance;
        $maxPowerOutput = $requiredPowerOutput + $tolerance;

        // Buscar proyectos que se encuentren dentro del rango de potencia con tolerancia
        $this->project = Project::whereBetween('power_output', [$minPowerOutput, $maxPowerOutput])
            ->first();

        if ($this->project) {
            $this->projectName = $this->project->projectCategory->name . " de " . $this->project->power_output . " kW.";
            $this->required_area = $this->project->required_area;
            $this->subtotal = $this->project->raw_value;
            $this->total = $this->project->sale_value;

            $material = Material::where('reference', 'Módulo Solar')->first();
            if ($material) {
                $panelPower = (float) $material->description;
                $this->panels_needed = ceil($requiredPowerOutput * 1000 / $panelPower);
            } else {
                $this->addError('energy_client', 'No se encontró el material con referencia Módulo Solar.');
            }
        } else {
            $this->subtotal = 0;
            $this->total = 0;
        }
    }

    public function updateCityAndRadiation(): void
    {
        $client = Client::find($this->selectedClientId);

        if ($client && $client->city) {
            $this->city = $client->city->name;
            $this->solar_radiation_level = $client->city->irradiance;
        } else {
            $this->solar_radiation_level = 0;
        }
    }

    public function getTotalFormattedProperty(): string
    {
        return "$ " . number_format($this->total, 0, '.', ',');
    }

    public function render(): View
    {
        return view('livewire.quotations.quotation-edit');
    }

    #[On('updatedQuotation')]
    public function updatedQuotation($quotation): void
    {
        redirect()->to('quotations');
    }
}
