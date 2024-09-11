<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\CashFlow;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function downloadQuotationPDF($quotationId)
    {
        // Obtener la cotización con el flujo de caja relacionado
        $quotation = Quotation::with(['client.city', 'cashFlow'])->findOrFail($quotationId);

        // Generar el PDF con la vista y los datos necesarios
        $pdf = Pdf::loadView('livewire.quotations.quotation-pdf', [
            'quotation' => $quotation,
            'cashFlow' => $quotation->cashFlow,
        ])->setPaper('a4');

        return $pdf->download('quotation_' . $quotation->consecutive . '.pdf');
    }
}
