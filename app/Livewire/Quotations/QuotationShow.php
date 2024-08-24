<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Illuminate\View\View;
use Livewire\Component;

class QuotationShow extends Component
{
    public $openShow = false;
    public $quotation;

    public function mount(Quotation $quotation): void
    {
        $this->quotation = $quotation;
    }

    public function render(): View
    {
        return view('livewire.quotations.quotation-show');
    }
}
