<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Component;
use Livewire\WithPagination;

class QuotationList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'quotation_date';
    public $sortDirection = 'desc';
    public $openCreate;

    protected $queryString = ['search', 'perPage', 'sortBy', 'sortDirection'];

    public function render()
    {
        $quotations = Quotation::with(['project', 'client'])
            ->where('quotation_date', 'LIKE', '%' . $this->search . '%')
            ->orWhere('validity_period', 'LIKE', '%' . $this->search . '%')
            ->orWhere('total_quotation_amount', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.quotations.quotation-list', compact('quotations'));
    }
}
