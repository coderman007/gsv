<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use App\Models\Quotation;
use App\Models\Client;
use App\Models\Project;

class QuotationCreate extends Component
{
    public $open_create = false;
    public $project_id;
    public $client_id;
    public $quotation_date;
    public $validity_period;
    public $total_quotation_amount;

    public function render()
    {
        $clients = Client::all();
        $projects = Project::all();

        return view('livewire.quotations.quotation-create', compact('clients', 'projects'));
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
    }
}
