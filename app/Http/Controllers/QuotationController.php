<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    public function downloadQuotationPDF($quotationId)
    {
        $quotation = Quotation::with('client.city')->findOrFail($quotationId);

        $pdf = Pdf::loadView('livewire.quotations.quotation-pdf', compact('quotation'))
            ->setPaper('a4');

        return $pdf->download('quotation_' . $quotation->consecutive . '.pdf');
    }
}
