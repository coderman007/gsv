<?php

namespace App\Livewire\Quotations;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class QuotationCreate extends Component
{
    // Propiedades de las que depende la existencia de la cotización
    public $clients;
    public $selectedClientId;
    public $newClientModal = false;
    public $project;

    // Datos importantes que definirán el proyecto
    public $average_energy_consumption; // Consumo promedio de energía del cliente
    public $solar_radiation_level; // Nivel de irradiación solar (Se tomo con base en la ubicación del cliente)
    public $transformer; // Define la potencia del transformador (Monofásico/Trifásico)
    public $roof_dimension; // Define las dimensiones de la cubierta donde se va a realizar la instalación los paneles solares

    // Propiedades para los recursos
    public $totalLaborCost;
    public $totalMaterialCost;
    public $totalToolCost;
    public $totalTransportCost;

    // Otras propiedades de la cotización
    public $commissions;
    public $quotation_date;
    public $validity_period;
    public $margin;
    public $subtotal;
    public $iva;
    public $discount;
    public $total_quotation_amount;

    protected $rules = [
        'selectedClientId' => 'required',
        'average_energy_consumption' => 'required|numeric|min:0',
        'solar_radiation_level' => 'required|numeric|min:0',
        'transformer' => 'required|in:Trifásico,Monofásico',
        'roof_dimension' => 'required|numeric|min:0',
        'commissions' => 'nullable|numeric|min:0',
        'quotation_date' => 'required|date',
        'validity_period' => 'required|integer|min:1',
        'margin' => 'nullable|numeric|min:0',
        'subtotal' => 'required|numeric|min:0',
        'iva' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'total_quotation_amount' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->clients = Client::all();
        $this->totalLaborCost = 0; // Inicializar en 0 u obtener el valor de la lógica correspondiente
        $this->totalMaterialCost = 0; // Inicializar en 0 u obtener el valor de la lógica correspondiente
        $this->totalToolCost = 0; // Inicializar en 0 u obtener el valor de la lógica correspondiente
        $this->totalTransportCost = 0; // Inicializar en 0 u obtener el valor de la lógica correspondiente
    }


    public function createQuotation()
    {
        $this->validate();

        $this->project = Project::where('kilowatts_to_provide', '>=', $this->average_energy_consumption)->first();

        if (!$this->project) {
            $this->addError('average_energy_consumption', 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.');
            return;
        }

        // Calcula los costos totales de mano de obra, materiales, herramientas y transporte asociados al proyecto
        $totalLaborCost = $this->project->totalLaborCost();
        $totalMaterialCost = $this->project->totalMaterialCost();
        $totalToolCost = $this->project->totalToolCost();
        $totalTransportCost = $this->project->totalTransportCost();

        // Calcula el subtotal
        $subtotal = $totalLaborCost + $totalMaterialCost + $totalToolCost + $totalTransportCost;

        // Calcula el IVA (asumiendo una tasa del 19%)
        $iva = $subtotal * 0.19;

        // Calcula el monto total de la cotización
        $totalQuotationAmount = $subtotal + $iva;

        Quotation::create([
            'project_id' => $this->project->id,
            'client_id' => $this->selectedClientId,
            'average_energy_consumption' => $this->average_energy_consumption,
            'solar_radiation_level' => $this->solar_radiation_level,
            'transformer' => $this->transformer,
            'roof_dimension' => $this->roof_dimension,
            'commissions' => $this->commissions,
            'quotation_date' => $this->quotation_date,
            'validity_period' => $this->validity_period,
            'margin' => $this->margin,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'discount' => $this->discount,
            'total_quotation_amount' => $totalQuotationAmount,
        ]);

        $this->reset(['selectedClientId', 'average_energy_consumption', 'project', 'solar_radiation_level', 'transformer', 'roof_dimension', 'commissions', 'quotation_date', 'validity_period', 'margin', 'subtotal', 'iva', 'discount', 'total_quotation_amount']);

        session()->flash('message', 'Cotización creada exitosamente.');
    }



    public function showNewClientModal()
    {
        $this->newClientModal = true;
    }

    public function hideNewClientModal()
    {
        $this->newClientModal = false;
    }

    public function render()
    {
        return view('livewire.quotations.quotation-create');
    }

    #[On('clientStored')]
    public function clientStored()
    {
        $this->clients = Client::all();
    }
}
