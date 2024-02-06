<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use App\Models\Quotation;
use App\Models\Client;
use App\Models\Project;

class QuotationCreate extends Component
{
    public $openCreate = false;
    public $showClientInfo = true;
    public $project_id;
    public $client_id;
    public $quotation_date;
    public $validity_period;
    public $total_quotation_amount;

    // Nuevo campo para manejar la apertura del modal de información del cliente
    public $openClientInfoModal = false;

    // Datos del nuevo cliente
    public $client_name;
    public $client_email;

    public function render()
    {
        $clients = Client::all();
        $projects = Project::all();
        $quotations = Quotation::all();
        $quotation = new Quotation();

        return view('livewire.quotations.quotation-create', compact('clients', 'projects', 'quotations', 'quotation'));
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'quotation_date' => 'required|date',
            'validity_period' => 'required|numeric',
            'total_quotation_amount' => 'required|numeric',
        ]);

        // Verificar si hay información de cliente para habilitar/deshabilitar campos
        $this->checkClientInfo();
    }

    public function saveQuotation()
    {
        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'quotation_date' => 'required|date',
            'validity_period' => 'required|numeric',
            'total_quotation_amount' => 'required|numeric',
        ]);

        Quotation::create([
            'project_id' => $this->project_id,
            'client_id' => $this->client_id,
            'quotation_date' => $this->quotation_date,
            'validity_period' => $this->validity_period,
            'total_quotation_amount' => $this->total_quotation_amount,
        ]);

        $this->reset();

        // Verificar si hay información de cliente para habilitar/deshabilitar campos
        $this->checkClientInfo();
    }

    public function openClientInfoModal()
    {
        $this->openClientInfoModal = true;
    }

    public function saveClientInfo()
    {
        $this->validate([
            'client_name' => 'required|string',
            'client_email' => 'required|email|unique:clients,email',
        ]);

        // Crear el nuevo cliente
        $newClient = Client::create([
            'name' => $this->client_name,
            'email' => $this->client_email,
        ]);

        // Actualizar el ID del cliente en el formulario principal
        $this->client_id = $newClient->id;

        // Cerrar el modal de información del cliente
        $this->openClientInfoModal = false;

        // Verificar si hay información de cliente para habilitar/deshabilitar campos
        $this->checkClientInfo();
    }

    // Método para verificar si hay información de cliente y habilitar/deshabilitar campos
    private function checkClientInfo()
    {
        $this->showClientInfo = !empty($this->client_id);
    }
}
