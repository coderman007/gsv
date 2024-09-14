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

        // Obtener las variables macroeconómicas desde el modelo CashFlow
        $cashFlow = $quotation->cashFlow;
        $macroVars = $cashFlow->loadMacroEconomicVariables();

        // Generar el PDF con la vista y los datos necesarios
        $pdf = Pdf::loadView('livewire.quotations.quotation-pdf', [
            'quotation' => $quotation,
            'cashFlow' => $cashFlow,
            'macroVars' => $macroVars, // Pasar las variables macroeconómicas
        ])->setPaper('a3', 'landscape'); // Establecer tamaño A4 en orientación horizontal

        return $pdf->download('quotation_' . $quotation->consecutive . '.pdf');
    }
}
