<?php

namespace App\Livewire\Resources\AdditionalCosts;

use App\Models\AdditionalCost;
use Illuminate\View\View;
use Livewire\Component;

class AdditionalCostShow extends Component
{
    public $openShow = false;
    public $additionalCost;

    public function mount(AdditionalCost $additionalCost): void
    {
        $this->additionalCost = $additionalCost;
    }

    public function render(): View
    {
        return view('livewire.resources.additional-costs.additional-cost-show');
    }
}
