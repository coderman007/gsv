<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\Quotation;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class QuotationDocumentController extends Controller
{
    public function downloadQuotation($quotationId)
    {
        $quotation = Quotation::find($quotationId);

        if (!$quotation) {
            return redirect()->back()->with('error', 'La cotización no existe.');
        }

        // Crear una nueva instancia de PhpWord
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Definir estilos
        $phpWord->addFontStyle('titleStyle', ['bold' => true, 'size' => 16]);
        $phpWord->addFontStyle('textStyle', ['size' => 12]);
        $phpWord->addParagraphStyle('centerStyle', ['alignment' => 'center']);
        $phpWord->addParagraphStyle('rightStyle', ['alignment' => 'right']);

        // Añadir logo
        $section->addImage(public_path('images/logo_word.png'), [
            'width' => 300,
            'height' => 100,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Añadir encabezado y datos del cliente
        $section->addText($quotation->consecutive, 'titleStyle', 'rightStyle');
        $section->addText("Medellín " . $quotation->quotation_date->format('d/m/Y'), 'textStyle');
        $section->addText("Señor: " . $quotation->client->name, 'textStyle');
        if ($quotation->client->company) {
            $section->addText("EMPRESA: " . $quotation->client->company, 'textStyle');
        }
        $section->addText("Ciudad: " . $quotation->client->city->name, 'textStyle');

        // Añadir un saludo
        $section->addText('Reciba un cordial saludo.', 'textStyle');
        $section->addText('De acuerdo con su requerimiento presentamos nuestra propuesta para suministrar e implementar un sistema de generación de energía solar fotovoltaica que promueva la eficiencia energética para su instalación.', 'textStyle');

        // Sección de antecedentes
        $section->addText("ANTECEDENTES", 'titleStyle');
        $section->addText("El consumo actual de energía es cercano a " . $quotation->energy_client . " kWh y el costo actual por kWh es de " . $quotation->kilowatt_cost . ", es decir que el gasto por energía es de $" . number_format($quotation->cashFlow->energy_generated_monthly * $quotation->kilowatt_cost) . " al mes.", 'textStyle');

        // Sección de tipo de sistema
        $section->addText("TIPO DE SISTEMA", 'titleStyle');
        $section->addText("Se contemplará el uso de un sistema On-Grid (paralelo con la red sin baterías) de " . $quotation->project->power_output . " kWp" . " para optimizar al máximo la producción energética; dicha configuración permite que el proyecto sea más funcional tanto técnica como económicamente.", 'textStyle');

        $section->addText(PHP_EOL);

        // Añadir logo del sistema
        $section->addImage(public_path('images/on-grid.png'), [
            'width' => 400,
            'height' => 220,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Insertar salto de página justo después de esta parte sin dejar espacio en blanco
        $section->addPageBreak(); // <-- Salto de página correcto aquí

        // Crear una nueva sección para "CÁLCULO DEL SISTEMA"
        $section->addText("CÁLCULO DEL SISTEMA:", 'titleStyle');
        $section->addText("Teniendo en cuenta que la zona se tiene en promedio 4.2 horas de sol directa al día, tu sistema solar fotovoltaico sería:", 'textStyle');

// Definir estilo de la tabla
        $phpWord->addTableStyle('calculationTable', [
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,  // Mayor espacio interno en las celdas
            'cellSpacing' => 100  // Espacio adicional entre las celdas
        ]);

// Crear la tabla
        $calculationTable = $section->addTable('calculationTable');

// Fila 1: # de paneles, potencia del sistema, energía generada y área (con tamaños específicos)
        $calculationTable->addRow(1200);  // Altura fija para la fila

// Celdas con ancho y alto específicos para mantener uniformidad
        $cellPaneles = $calculationTable->addCell(3500, [
            'bgColor' => '92D050',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,  // Ancho específico para la celda
            'height' => 1500  // Alto específico para la celda
        ]);

        $cellPotencia = $calculationTable->addCell(3500, [
            'bgColor' => '92D050',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,
            'height' => 1500
        ]);

        $cellEnergia = $calculationTable->addCell(3500, [
            'bgColor' => '92D050',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,
            'height' => 1500
        ]);

        $cellArea = $calculationTable->addCell(3500, [
            'bgColor' => 'D9D9D9',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,
            'height' => 1500
        ]);

// Añadir el texto con alineación centrada
        $cellPaneles->addText("NÚMERO DE PANELES", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellPaneles->addText($quotation->panels_needed, ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellPotencia->addText("POTENCIA SISTEMA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellPotencia->addText($quotation->project->power_output . " kWp", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellEnergia->addText("ENERGÍA GENERADA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellEnergia->addText(($quotation->project->power_output * 4.2 * 30) . " kWh-mes", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellArea->addText("ÁREA NECESARIA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellArea->addText($quotation->required_area . " m2", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

// Añadir fila adicional con espacio específico
        $calculationTable->addRow(300);  // Fila vacía para espacio adicional

// Fila 2: Consumo actual y ahorro mensual (tamaños uniformes)
        $cellConsumo = $calculationTable->addCell(3500, [
            'bgColor' => 'orange',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,
            'height' => 1500
        ]);

        $cellAhorro = $calculationTable->addCell(3500, [
            'bgColor' => '00B0F0',
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 200,
            'valign' => 'center',
            'width' => 3500,
            'height' => 1500
        ]);

        $cellConsumo->addText("CONSUMO ACTUAL", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $cellConsumo->addText($quotation->energy_client . " kWh", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellAhorro->addText("AHORRO MENSUAL", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $cellAhorro->addText("100%", ['bold' => true, 'size' => 12], ['alignment' => 'center']);



        // Añadir presupuesto
        $section->addText("PRESUPUESTO EPC:", 'titleStyle');
        $section->addText("SISTEMA SOLAR FOTOVOLTAICO ON-GRID: $" . number_format($quotation->total, 2), 'textStyle');

        // Añadir análisis financiero
        $cashFlow = CashFlow::where('quotation_id', $quotation->id)->first();
        if ($cashFlow) {
            $section->addText("ANÁLISIS FINANCIERO:", 'titleStyle');
            $section->addText("TIR: " . $cashFlow->internal_rate_of_return . "%", 'textStyle');
            $section->addText("Tiempo de recuperación de la inversión (TBT): " . $cashFlow->payback_time . " años", 'textStyle');

            // Añadir tabla de caja acumulada
            $section->addText("CAJA ACUMULADA:", 'titleStyle');
            $table = $section->addTable('productTable');
            $table->addRow();
            $table->addCell(1000)->addText("Año", 'textStyle');
            $table->addCell(3000)->addText("Caja acumulada", 'textStyle');

            $accumulatedCashFlow = json_decode($cashFlow->accumulated_cash_flow, true);
            foreach ($accumulatedCashFlow as $year => $value) {
                $table->addRow();
                $table->addCell(1000)->addText($year, 'textStyle');
                $table->addCell(3000)->addText(number_format($value, 2), 'textStyle');
            }
        }

        // Guardar y descargar el archivo
        $fileName = 'Cotización_' . $quotation->consecutive . '.docx';
        $tempFile = storage_path('app/' . $fileName);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
