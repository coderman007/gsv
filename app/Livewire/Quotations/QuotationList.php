<?php

namespace App\Livewire\Quotations;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Quotation_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Quotation;
use Livewire\WithPagination;

/**
 * @property array|LengthAwarePaginator|_IH_Quotation_C|mixed|null $quotations
 */
class QuotationList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perSearch = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function order($sort): void
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }
    }

    #[Computed]
    public function quotations(): array|LengthAwarePaginator|_IH_Quotation_C
    {
        return Quotation::where('consecutive', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orWhere('quotation_date', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdQuotation')]
    public function createdQuotation($quotationData = null)
    {
    }

    #[On('notification')]
    public function notify($message = null)
    {
    }

    #[On('updatedQuotation')]
    public function updatedQuotation($quotation = null)
    {
    }

    #[On('deletedQuotation')]
    public function deletedQuotation($quotation = null)
    {
    }

    public function render(): View
    {
        return view('livewire.quotations.quotation-list');
    }
}
