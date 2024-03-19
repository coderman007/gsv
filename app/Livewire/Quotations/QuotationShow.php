<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Component;

class QuotationShow extends Component
{
    public $openShow = false;
    public $quotation;

    public function mount(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function render()
    {
        return view('livewire.quotations.quotation-show');
    }
}
