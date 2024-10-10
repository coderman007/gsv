<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class QuotationDocumentController extends Controller
{
    public function generateCashFlowChart($accumulated_cash_flow)
    {
        // Dimensiones de la imagen
        $width = 2000;
        $height = 1000;

        // Crear la imagen
        $image = imagecreatetruecolor($width, $height);

        // Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $blue = imagecolorallocate($image, 0, 0, 255);
        $gray = imagecolorallocate($image, 200, 200, 200);
        $yellow = imagecolorallocate($image, 255, 192, 0);
        $green = imagecolorallocate($image, 84, 130, 53);

        // Rellenar el fondo con blanco
        imagefill($image, 0, 0, $white);

        // Dibujar el eje X y el eje Y
        $xAxisYPosition = 350; // Posición del eje X en el medio de la imagen (para valores negativos y positivos)
        imageline($image, 50, $xAxisYPosition, 1450, $xAxisYPosition, $black); // Eje X
        imageline($image, 50, 50, 50, 650, $black); // Eje Y

        // Obtener el valor máximo y mínimo del flujo de caja acumulado
        $maxValue = max($accumulated_cash_flow);
        $minValue = min($accumulated_cash_flow);

        // Calcular la escala para el eje Y
        $yScale = max(abs($maxValue), abs($minValue)) / 300; // Asegurarse de que tanto el valor positivo más alto como el negativo se ajusten a la escala

        // Dibujar etiquetas en el eje Y solo para los años 1, 5, 10, 15, 20, 25
        $yearsToLabel = [1, 5, 10, 15, 20, 25];

        foreach ($yearsToLabel as $year) {
            // Etiqueta del valor acumulado para ese año
            $yLabelValue = $accumulated_cash_flow[$year];
            $yPos = $xAxisYPosition - ($yLabelValue / $yScale); // Ajustar la posición vertical según el valor

            imagestring($image, 2, 10, $yPos - 5, number_format($yLabelValue, 2), $black); // Etiqueta del valor
            imageline($image, 50, $yPos, 1450, $yPos, $gray); // Línea guía en el gráfico
        }

        // Dibujar las barras para cada año
        foreach ($accumulated_cash_flow as $year => $value) {
            $xPos = 50 + ($year * 55); // Ajuste del espacio entre años en el eje X
            $barWidth = 30; // Ancho de cada barra

            // Determinar el color de la barra (amarillo si es negativo, verde si es positivo)
            $barColor = $value < 0 ? $yellow : $green;

            // Dibujar la barra hacia arriba o hacia abajo según corresponda
            if ($value < 0) {
                $barHeight = abs($value) / $yScale; // Altura de la barra (positiva)
                imagefilledrectangle($image, $xPos, $xAxisYPosition, $xPos + $barWidth, $xAxisYPosition + $barHeight, $barColor); // Barra hacia abajo
            } else {
                $barHeight = $value / $yScale;
                imagefilledrectangle($image, $xPos, $xAxisYPosition - $barHeight, $xPos + $barWidth, $xAxisYPosition, $barColor); // Barra hacia arriba
            }

            // Mostrar el número del año justo debajo de la barra
            imagestring($image, 2, $xPos + 5, $xAxisYPosition + 5, $year, $black); // Ajuste de la posición de la etiqueta
        }

        // Guardar la imagen en un archivo
        $imagePath = public_path('images/flujo_caja_acumulado_barras.png');
        imagepng($image, $imagePath);

        // Liberar la memoria
        imagedestroy($image);

        return $imagePath;
    }

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

        $section->addPageBreak(); // Salto de página

        // Añadir logo
        $section->addImage(public_path('images/logo_word.png'), [
            'width' => 300,
            'height' => 100,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Crear una nueva sección para "CÁLCULO DEL SISTEMA"
        $section->addText("CÁLCULO DEL SISTEMA", 'titleStyle');
        $section->addText("Teniendo en cuenta que la zona se tiene en promedio 4.2 horas de sol directa al día, tu sistema solar fotovoltaico sería:", 'textStyle');

// Definir estilo de la tabla
        $phpWord->addTableStyle('calculationTable', [
            'borderSize' => 6,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 100,  // Mayor espacio interno en las celdas
            'cellSpacing' => 50  // Espacio adicional entre las celdas
        ]);

// Crear la tabla
        $calculationTable = $section->addTable('calculationTable');

// Fila 1: # de paneles, potencia del sistema, energía generada y área (con tamaños específicos)
        $calculationTable->addRow(1200);  // Altura fija para la fila

// Celdas con ancho y altura específicos para mantener uniformidad
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

        $section->addText(PHP_EOL);

        // Definir estilo de la nueva tabla para la sección de detalles con margen interior reducido
        $phpWord->addTableStyle('detailsTable', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMarginTop' => 50,     // Reducir margen superior
            'cellMarginBottom' => 50,  // Reducir margen inferior
            'cellMarginLeft' => 50,    // Reducir margen izquierdo
            'cellMarginRight' => 50,   // Reducir margen derecho
        ]);

// Crear la tabla para la sección de detalles
        $detailsTable = $section->addTable('detailsTable');

// Agregar encabezado de la tabla (Descripción y Cantidad)
        $detailsTable->addRow(400);  // Reducir la altura de la fila para el encabezado
        $detailsTable->addCell(8000, ['bgColor' => 'D9D9D9'])->addText("DESCRIPCIÓN", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $detailsTable->addCell(2000, ['bgColor' => 'D9D9D9'])->addText("CANTIDAD", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

// Agregar las filas de detalles basados en la imagen proporcionada
        $items = [
            ["Panel solar fotovoltaico bifacial 575 Wp", "CANT"],
            ["Inversores monofásico 220V-60Hz", "CANT"],
            ["Estructuras paneles solares", "1"],
            ["Adecuaciones eléctricas internas y medidor", "1"],
            ["Certificación RETIE", "1"],
            ["Trámites con el comercializador", "1"],
            ["Trámites UPME Ley 1715-2014", "1"],
            ["Sistema de Monitoreo", "1"],
            ["Ingeniería y mano de obra", "1"],
        ];

// Llenar las filas con los detalles y reducir la altura de las filas
        foreach ($items as $item) {
            $detailsTable->addRow(400);  // Reducir la altura de cada fila a 400
            $detailsTable->addCell(8000, ['valign' => 'center'])->addText($item[0], ['size' => 12], ['alignment' => 'left']);
            $detailsTable->addCell(2000, ['valign' => 'center'])->addText($item[1], ['size' => 12], ['alignment' => 'center']);
        }

        $section->addPageBreak(); // Salto de página

        // Añadir logo
        $section->addImage(public_path('images/logo_word.png'), [
            'width' => 300,
            'height' => 100,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        // Añadir sección de Presupuesto EPC con descripción y valores
        $section->addText("PRESUPUESTO EPC", 'titleStyle', 'centerStyle');

        // Añadir tabla de presupuesto
        $phpWord->addTableStyle('budgetTable', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);
        $budgetTable = $section->addTable('budgetTable');

        // Encabezado
        $budgetTable->addRow();
        $budgetTable->addCell(8000, ['bgColor' => 'D9D9D9'])->addText("DESCRIPCIÓN", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $budgetTable->addCell(3000, ['bgColor' => 'D9D9D9'])->addText("VALOR", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        // Fila de sistema solar
        $budgetTable->addRow();
        $budgetTable->addCell(8000)->addText("SISTEMA SOLAR FOTOVOLTAICO ON-GRID: " . $quotation->project->power_output . " KWP", ['size' => 12], ['alignment' => 'left']);
        $budgetTable->addCell(3000)->addText("$" . number_format($quotation->total, 2), ['size' => 12], ['alignment' => 'center']);

        // Subtotal e IVA
        $budgetTable->addRow();
        $budgetTable->addCell(8000)->addText("SUBTOTAL", ['size' => 12], ['alignment' => 'right']);
        $budgetTable->addCell(3000)->addText("$" . number_format($quotation->total, 2), ['size' => 12], ['alignment' => 'center']);

        $budgetTable->addRow();
        $budgetTable->addCell(8000)->addText("IVA", ['size' => 12], ['alignment' => 'right']);
        $budgetTable->addCell(3000)->addText("$ 0", ['size' => 12], ['alignment' => 'center']);

        // Total
        $budgetTable->addRow();
        $budgetTable->addCell(8000, ['bgColor' => 'D9D9D9'])->addText("TOTAL", ['bold' => true, 'size' => 12], ['alignment' => 'right']);
        $budgetTable->addCell(3000, ['bgColor' => 'D9D9D9'])->addText("$" . number_format($quotation->total, 2), ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $section->addTextBreak(2);

        // --- Sección Análisis Financiero ---
        $section->addText("ANÁLISIS FINANCIERO", 'titleStyle', 'centerStyle');

// Crear tabla con un borde externo único (sin bordes)
        $phpWord->addTableStyle('financialAnalysisTable', [
            'borderSize' => 0,  // Define el borde externo de la tabla a 0
            'cellMargin' => 50,
            'cellSpacing' => 0,  // Sin separación interna entre celdas
        ]);

// Crear la tabla con una sola fila y dos celdas (Contenedor principal)
        $financialAnalysisTable = $section->addTable('financialAnalysisTable');
        $financialAnalysisTable->addRow(3000); // Ajuste de altura de la fila

        // Añadir la gráfica del flujo de caja acumulado en barras
        $accumulatedCashFlow = json_decode($quotation->cashFlow->accumulated_cash_flow, true);
        $imagePath = $this->generateCashFlowChart($accumulatedCashFlow);

        // Ajuste del ancho de las celdas para distribuir el espacio de manera proporcional
        $graphWidth = 12000; // 75% del ancho total
        $indicatorWidth = 4000; // 25% del ancho total

        // Primera celda: Contenedor de la gráfica (Izquierda)
        $cellGraph = $financialAnalysisTable->addCell($graphWidth, [
            'valign' => 'center',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'borderSize' => 0,  // Sin borde para la celda de la gráfica
            'bgColor' => 'FFFFFF'  // Fondo blanco
        ]);
        $cellGraph->addImage($imagePath, [
            'width' => 600,  // Ajustar el tamaño de la gráfica según sea necesario
            'height' => 300,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

// Segunda celda: Contenedor de los indicadores financieros (Derecha)
        $cellIndicators = $financialAnalysisTable->addCell($indicatorWidth, [
            'valign' => 'center',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'borderSize' => 0,  // Sin borde para la celda de indicadores
        ]);

// Crear una tabla interna sin bordes para mostrar TIR y Payback Time (celda derecha)
        $phpWord->addTableStyle('innerIndicatorTable', [
            'borderSize' => 0,
            'cellMargin' => 50,
            'cellSpacing' => 0,
        ]);

        $indicatorTable = $cellIndicators->addTable('innerIndicatorTable');

// Fila 1: TIR (Parte superior del contenedor derecho)
        $indicatorTable->addRow(1500);  // Ajuste de altura de fila para mantener la proporción con la imagen
        $cellTIR = $indicatorTable->addCell($indicatorWidth, [
            'bgColor' => 'C5E0B3',  // Verde claro para la celda
            'borderSize' => 0,  // Sin borde
            'valign' => 'center',
        ]);
        $cellTIR->addText("Tasa Interna de Retorno (TIR)", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $cellTIR->addText($quotation->cashFlow->internal_rate_of_return . "%", ['bold' => true, 'size' => 16], ['alignment' => 'center']);

// Fila 2: Payback Time (Parte inferior del contenedor derecho)
        $indicatorTable->addRow(1500);  // Ajuste de altura de fila para mantener la proporción con la imagen
        $cellPayback = $indicatorTable->addCell($indicatorWidth, [
            'bgColor' => 'C5E0B3',  // Verde claro para la celda
            'borderSize' => 0,  // Sin borde
            'valign' => 'center',
        ]);
        $cellPayback->addText("Tiempo de Recuperación (Payback Time)", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $cellPayback->addText($quotation->cashFlow->payback_time . " años", ['bold' => true, 'size' => 16], ['alignment' => 'center']);

// --- Nueva Sección: Formas de Pago ---
        $section->addTextBreak(1);  // Añadir un salto de línea
        $section->addText("FORMAS DE PAGO", 'titleStyle', 'leftStyle');

// Forma de pago contado
        $section->addText("CONTADO:", ['bold' => true, 'size' => 12], ['alignment' => 'left']);
        $section->addText(
            "30% Anticipo\n" .
            "40% Contra entrega de diseño de ingeniería de detalle.\n" .
            "20% Contra entrega de obra (equipos instalados)\n" .
            "10% Contra cambio de medidor por parte del comercializador.",
            ['size' => 11],
            ['alignment' => 'left']
        );

// Forma de pago financiado
        $section->addText("FINANCIADO:", ['bold' => true, 'size' => 12], ['alignment' => 'left']);

// Crear una tabla para alinear la imagen y los planes de financiación
        $phpWord->addTableStyle('paymentTable', [
            'borderSize' => 0,
            'cellMargin' => 50,
            'cellSpacing' => 50,
        ]);

        $paymentTable = $section->addTable('paymentTable');
        $paymentTable->addRow(2000);

// Celda 1: Contenedor de la imagen
        $cellImage = $paymentTable->addCell(4000, [
            'valign' => 'center',
            'alignment' => Jc::LEFT,  // Cambiar JcTable::LEFT a Jc::LEFT
            'borderSize' => 0,
        ]);
        // Corregido el cierre de paréntesis en la llamada a addImage
        $cellImage->addImage(public_path('images/somos.PNG'), [
            'width' => 150,
            'height' => 150,
            'alignment' => Jc::CENTER  // Esto está bien ya que se usa Jc::CENTER para imágenes
        ]);

// Celda 2: Contenedor de los planes de financiación
        $cellPlans = $paymentTable->addCell(6000, [
            'valign' => 'center',
            'alignment' => Jc::LEFT,  // Cambiar JcTable::LEFT a Jc::LEFT
            'borderSize' => 0,
        ]);
        $cellPlans->addText("48 cuotas de: $482.728", ['bold' => true, 'size' => 12], ['alignment' => 'left']);
        $cellPlans->addText("60 cuotas de: $417.298", ['bold' => true, 'size' => 12], ['alignment' => 'left']);
        $cellPlans->addText("20 cuotas de: $296.104", ['bold' => true, 'size' => 12], ['alignment' => 'left']);
        // Añadir tabla de caja acumulada
        $section->addText("CAJA ACUMULADA:", 'titleStyle');
        $table = $section->addTable('productTable');
        $table->addRow();
        $table->addCell(1000)->addText("Año", 'textStyle');
        $table->addCell(3000)->addText("Caja acumulada", 'textStyle');

        $accumulatedCashFlow = json_decode($quotation->cashFlow->accumulated_cash_flow, true);
        foreach ($accumulatedCashFlow as $year => $value) {
            $table->addRow();
            $table->addCell(1000)->addText($year, 'textStyle');
            $table->addCell(3000)->addText(number_format($value, 2), 'textStyle');
        }

        // Guardar y descargar el archivo
        $fileName = 'Cotización_' . $quotation->consecutive . '.docx';
        $tempFile = storage_path('app/' . $fileName);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
