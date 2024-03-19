<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use App\Models\Quotation;
use App\Models\Client;
use Livewire\WithPagination;

class QuotationList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perSearch = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function order($sort)
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }
    }

    public function quotations()
    {
        return Quotation::with(['project', 'client'])
            ->whereHas('client', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('quotation_date', 'like', '%' . $this->search . '%')
            ->orWhere('total_quotation_amount', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    public function render()
    {
        return view('livewire.quotations.quotation-list', [
            'quotations' => $this->quotations(),
        ]);
    }
}
