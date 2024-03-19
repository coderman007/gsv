<?php

namespace App\Livewire\Quotations;

use App\Models\Quotation;
use Livewire\Component;

class QuotationDelete extends Component
{
    public $openDelete = false;
    public $quotation;

    public function mount(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function deleteQuotation()
    {
        if ($this->quotation) {
            $this->quotation->delete();
            // Emitir eventos y notificaciones si es necesario
            $this->dispatch('deletedQuotation');
            $this->dispatch('deletedQuotationNotification', [
                'title' => 'Éxito',
                'text' => '¡Cotización Eliminada!',
                'icon' => 'success'
            ]);
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.quotations.quotation-delete');
    }
}
