<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Component;

class QuotationList extends Component
{
    public $quotations;
    public $showCreateModal;
    

    public function render()
    {
        // Retrieve quotations with related project and client
        $this->quotations = Quotation::with(['project', 'client'])->get();

        return view('livewire.quotations.quotation-list');
    }

    public function toggleCreateModal()
    {
        $this->showCreateModal = !$this->showCreateModal;
    }
}