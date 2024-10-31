<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Language;

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

        // Configurar el idioma predeterminado del documento a español (por ejemplo, español de Colombia)
        $phpWord->getSettings()->setThemeFontLang(new Language(Language::ES_ES));

        // Ajustar tipo de letra predeterminado a Century Gothic
        $phpWord->setDefaultFontName('Century Gothic');
        $phpWord->setDefaultFontSize(12);

        // Establecer estilo de párrafo predeterminado para alineación y interlineado
        $phpWord->setDefaultParagraphStyle([
            'alignment' => Jc::BOTH,   // Alineación justificada
            'spacing' => ['after' => 0, 'line' => 240], // Interlineado automático
        ]);

        $section = $phpWord->addSection();

        // Agregar encabezado
        $header = $section->addHeader();
        $header->addImage(public_path('images/logo_word.png'), [
            'width' => 220,
            'height' => 75,
            'alignment' => Jc::CENTER
        ]);

        $sellerName = Auth::user()->name;

        // Definir estilos
        $phpWord->addFontStyle('titleStyle', ['bold' => true, 'size' => 12]);
        $phpWord->addFontStyle('textStyle', ['size' => 12]);
        $phpWord->addFontStyle('boldStyle', ['bold' => true, 'size' => 12]);
        $phpWord->addParagraphStyle('centerStyle', ['alignment' => 'center']);
        $phpWord->addParagraphStyle('leftStyle', ['alignment' => 'left']);
        $phpWord->addParagraphStyle('rightStyle', ['alignment' => 'right']);
        $phpWord->addParagraphStyle('justifiedStyle', [
            'alignment' => Jc::BOTH,      // Justificar el texto
            'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), // Espacio después del párrafo
            'lineHeight' => 1.15          // Interlineado automático
        ]);


// Añadir encabezado y datos del cliente utilizando addTextRun para negrita
        $textRun = $section->addTextRun(['alignment' => Jc::END]); // Alinear el TextRun a la derecha

// Consecutivo en negrita, alineado a la derecha
        $textRun->addText($quotation->consecutive, ['bold' => true]);


        // Fecha de cotización con negrita solo en el dato, alineada a la derecha
        $textRun = $section->addTextRun(['alignment' => Jc::START]);
        $textRun->addText("Medellín ", 'textStyle');
        $textRun->addText($quotation->quotation_date->format('d/m/Y'), ['bold' => true]);

        $section->addText(PHP_EOL);

        // ----- Pie de página -----
        $footer = $section->addFooter();

        // Modificar tamaño de fuente y alineación para el pie de página
        $footer->addText(
            'Cra. 52 # 52-63 - CC. Itagüí Plaza - Local 409, Itagüí - Antioquia',
            ['size' => 10], // Cambiar el tamaño de la fuente a 9
            ['alignment' => Jc::CENTER]
        );
        $footer->addText(
            '+57 3007187730 | comercial@gsvingenieria.com | www.gsvingenieria.com',
            ['size' => 10], // Cambiar el tamaño de la fuente a 9
            ['alignment' => Jc::CENTER]
        );


// Nombre del cliente con negrita en el dato
        $textRun = $section->addTextRun();
        $textRun->addText("Señor(a): ", 'textStyle');
        $textRun->addText($quotation->client->name, ['bold' => true], 'textStyle');


//        // Empresa solo si existe, con negrita en el dato
//        if ($quotation->client->company) {
//            $textRun = $section->addTextRun();
//            $textRun->addText("EMPRESA: ", 'textStyle');
//            $textRun->addText($quotation->client->company, ['bold' => true], 'textStyle');
//
//        }

        // Ciudad con negrita en el dato
        $textRun = $section->addTextRun();
        $textRun->addText("Ubicación: ", 'textStyle');
        $textRun->addText($quotation->client->city->name, ['bold' => true], 'textStyle');

        $section->addText(PHP_EOL);

        // Añadir un saludo
        $section->addText('Reciba un cordial saludo.', 'textStyle');
        $section->addText('De acuerdo con su requerimiento presentamos nuestra propuesta para suministrar e implementar un sistema de generación de energía solar fotovoltaica que promueva la eficiencia energética para su instalación.', 'textStyle');

        // Agregar un salto de línea
        $section->addText(PHP_EOL);

        // Sección de antecedentes
        $section->addText("ANTECEDENTES", 'titleStyle');

        // Crear un TextRun para la sección de antecedentes
        $textRun = $section->addTextRun();
        $textRun->addText("El consumo actual de energía es cercano a ", 'textStyle');
        $textRun->addText(number_format($quotation->energy_client, 0) . " kWh", ['bold' => true], 'textStyle');
        $textRun->addText(" y el costo actual por kWh es de ", 'textStyle');
        $textRun->addText("$ " . number_format($quotation->kilowatt_cost), ['bold' => true], 'textStyle');
        $textRun->addText(", es decir que el gasto por energía es de ", 'textStyle');
        $textRun->addText("$ " . number_format($quotation->energy_client * $quotation->kilowatt_cost), ['bold' => true], 'textStyle');
        $textRun->addText(" al mes.", 'textStyle');

        $section->addText(PHP_EOL); // Salto de línea

// Sección de tipo de sistema
        $section->addText("TIPO DE SISTEMA", 'titleStyle');

// Crear un TextRun para la sección de tipo de sistema
        $textRun = $section->addTextRun();
        $textRun->addText("Se contemplará el uso de un sistema On-Grid (paralelo con la red sin baterías) de ", 'textStyle');
        $textRun->addText($quotation->project->power_output . " kWp", ['bold' => true], 'textStyle');
        $textRun->addText(" para optimizar al máximo la producción energética; dicha configuración permite que el proyecto sea más funcional tanto técnica como económicamente.", 'textStyle');

        // Añadir logo del sistema
        $section->addImage(public_path('images/on-grid.png'), [
            'width' => 400,
            'height' => 180,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
        ]);

        $section->addPageBreak(); // Salto de página

        // Crear un TextRun para el promedio de horas de sol directo
        $textRun = $section->addTextRun();
        $textRun->addText("Teniendo en cuenta que la zona tiene en promedio ", 'textStyle');
        $textRun->addText(number_format($quotation->client->city->irradiance, 1), ['bold' => true], 'textStyle');
        $textRun->addText(" horas de sol directo al día", 'textStyle');
        $textRun->addText(", tu sistema solar fotovoltaico sería:", 'textStyle');

// Definir estilo de la tabla
        $phpWord->addTableStyle('calculationTable', [
            'borderSize' => 6,
            'borderColor' => '#FFFFFF',
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
        $cellPaneles->addText(number_format($quotation->panels_needed), ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellPotencia->addText("POTENCIA SISTEMA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellPotencia->addText(number_format($quotation->project->power_output, 1) . " kWp", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellEnergia->addText("ENERGÍA GENERADA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellEnergia->addText(number_format(($quotation->project->power_output) * 4.2 * 30) . " kWh-mes", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $cellArea->addText("ÁREA NECESARIA", ['bold' => true, 'size' => 12, 'color' => '000000'], ['alignment' => 'center']);
        $cellArea->addText(number_format($quotation->required_area) . " m²", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

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
        $cellConsumo->addText(number_format($quotation->energy_client) . " kWh", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

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
            ["Panel solar fotovoltaico bifacial 575 Wp", number_format($quotation->panels_needed)],
            ["Inversores monofásico 220V-60Hz", "X"],
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

        // Añadir sección de Presupuesto EPC con descripción y valores
        $section->addText("PRESUPUESTO EPC (LLAVE EN MANO)", 'titleStyle', 'centerStyle');

// Añadir tabla principal (Descripción del sistema solar)
        $phpWord->addTableStyle('mainTable', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);
        $mainTable = $section->addTable('mainTable');

// Encabezado
        $mainTable->addRow();
        $mainTable->addCell(8000, ['bgColor' => 'D9D9D9'])->addText("DESCRIPCIÓN", ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        $mainTable->addCell(3000, ['bgColor' => 'D9D9D9'])->addText("VALOR", ['bold' => true, 'size' => 12], ['alignment' => 'center']);

// Fila de sistema solar
        $mainTable->addRow();
        $mainTable->addCell(8000)->addText("SISTEMA SOLAR FOTOVOLTAICO ON-GRID: " . $quotation->project->power_output . " KWP", ['size' => 12], ['alignment' => 'left']);
        $mainTable->addCell(3000)->addText("$ " . number_format($quotation->total), ['size' => 12], ['alignment' => 'center']);

// Crear segunda tabla (para Subtotal, IVA y Total)
        $phpWord->addTableStyle('totalsTable', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);
        $totalsTable = $section->addTable('totalsTable', ['alignment' => 'right']); // Alineación a la derecha

// Fila de Subtotal
        $totalsTable->addRow();
        $totalsTable->addCell(4000)->addText("SUBTOTAL", ['size' => 12, 'bold' => true], ['alignment' => 'right']);
        $totalsTable->addCell(3000)->addText("$ " . number_format($quotation->total), ['size' => 12], ['alignment' => 'center']);

// Fila de IVA
        $totalsTable->addRow();
        $totalsTable->addCell(4000)->addText("IVA", ['size' => 12, 'bold' => true], ['alignment' => 'right']);
        $totalsTable->addCell(3000)->addText("$ 0", ['size' => 12], ['alignment' => 'center']);

// Fila de Total
        $totalsTable->addRow();
        $totalsTable->addCell(4000, ['bgColor' => 'D9D9D9'])->addText("TOTAL", ['bold' => true, 'size' => 12], ['alignment' => 'right']);
        $totalsTable->addCell(3000, ['bgColor' => 'D9D9D9'])->addText("$ " . number_format($quotation->total), ['bold' => true, 'size' => 12], ['alignment' => 'center']);

        $section->addText(PHP_EOL);

        // --- Sección de la gráfica y valores (reformulada) ---
        $section->addText("FLUJO DE CAJA ACUMULADA", 'titleStyle', 'centerStyle');

        // Añadir la imagen de flujo de caja acumulado
        $section->addImage(public_path('images/cashflow_chart.png'), [
            'width' => 500,
            'height' => 200,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER // Centra la imagen
        ]);

        // Estilo de la tabla para TIR y Payback Time con borde blanco
        $phpWord->addTableStyle('tirPaybackTable', [
            'borderSize' => 1,        // Tamaño del borde (ajusta según lo necesites)
            'borderColor' => 'FFFFFF', // Color del borde en formato hex (blanco)
            'cellMargin' => 50,
        ]);

        $tirPaybackTable = $section->addTable('tirPaybackTable');

// Fila para los indicadores financieros (TIR y Payback Time)
        $tirPaybackTable->addRow(400);

// Celda para la TIR
        $cellTir = $tirPaybackTable->addCell(5000, [
            'bgColor' => '92D050',
            'valign' => 'center',
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        ]);

        $cellTir->addText("RENTABILIDAD DE LA INVERSIÓN", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $cellTir->addText($quotation->cashFlow->internal_rate_of_return . "%", ['bold' => true, 'size' => 16, 'color' => 'black'], ['alignment' => 'center']);

// Celda vacía (10 píxeles de ancho)
        $cellEmpty = $tirPaybackTable->addCell(10 * 20, [ // 10 píxeles convertidos a puntos
            'valign' => 'center',
        ]);

// Celda para Payback Time
        $cellPayback = $tirPaybackTable->addCell(5000, [
            'bgColor' => '92D050',
            'valign' => 'center',
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        ]);

        $cellPayback->addText("TIEMPO DE RECUPERACIÓN DE LA INVERSIÓN", ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $cellPayback->addText(number_format($quotation->cashFlow->payback_time, 1) . " años", ['bold' => true, 'size' => 16, 'color' => 'black'], ['alignment' => 'center']);

        $section->addPageBreak(); // Salto de página

        // --- Nueva Sección: Formas de Pago ---
        $section->addText("FORMAS DE PAGO", 'titleStyle', 'leftStyle');

// Forma de pago contado
        $section->addText("CONTADO:", ['bold' => true, 'size' => 12], ['alignment' => 'left']);

// Detalles de pago en formato de viñetas
        $section->addListItem("30% Anticipo.", 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("40% Contra entrega de diseño de ingeniería de detalle.", 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("20% Contra entrega de obra (equipos instalados).", 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("10% Contra cambio de medidor por parte del comercializador.", 0, null, ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);

// Forma de pago financiado
        $section->addText("FINANCIADO:", ['bold' => true, 'size' => 12], ['alignment' => 'left']);

// Crear una tabla simple para alinear la imagen y los planes de financiación
        $paymentTable = $section->addTable([
            'borderSize' => 6,  // Tamaño del borde
            'borderColor' => 'FFFFFF',  // Color blanco
        ]);

        $paymentTable->addRow(2000);

// Celda 1: Contenedor de la imagen
        $cellImage = $paymentTable->addCell(4000, [
            'valign' => 'center',
            'alignment' => Jc::LEFT
        ]);
        $cellImage->addImage(public_path('images/somos.PNG'), [
            'width' => 120,
            'height' => 80,
            'alignment' => Jc::CENTER
        ]);

// Celda 2: Contenedor de los planes de financiación
        $cellPlans = $paymentTable->addCell(6000, [
            'valign' => 'center',
            'alignment' => Jc::START
        ]);

        // Para 48 cuotas
        $textRun = $cellPlans->addTextRun(['alignment' => 'left']);
        $textRun->addText("  48 cuotas de: ", ['bold' => false, 'size' => 12]);
        $textRun->addText("$ XXXXXX", ['bold' => true, 'size' => 12]);

        // Para 48 cuotas
        $textRun = $cellPlans->addTextRun(['alignment' => 'left']);
        $textRun->addText("  60 cuotas de: ", ['bold' => false, 'size' => 12]);
        $textRun->addText("$ XXXXXX", ['bold' => true, 'size' => 12]);

        // Para 48 cuotas
        $textRun = $cellPlans->addTextRun(['alignment' => 'left']);
        $textRun->addText("120 cuotas de: ", ['bold' => false, 'size' => 12]);
        $textRun->addText("$ XXXXXX", ['bold' => true, 'size' => 12]);

        // Sección de garantías
        $section->addText("GARANTÍAS:", 'titleStyle');

// Detalles de garantías en formato de viñetas
        $section->addListItem("Para los paneles solares: 10 años al 91.2% de la potencia de salida mínima y 25 años al 80.7% de la potencia de salida mínima.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("Para los inversores: 5 años de garantía por defectos de fábrica.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("Para la instalación: 5 años de garantía.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);

// Sección de beneficios tributarios
        $section->addText("BENEFICIOS TRIBUTARIOS LEY 1715 DE 2014:", 'titleStyle');

// Detalles de beneficios tributarios en formato de viñetas
        $section->addListItem("Descuento del 50% del valor de la inversión en renta líquida.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("Depreciación acelerada del activo en hasta 3 años.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);
        $section->addListItem("Cero impuestos de IVA en bienes y servicios.", 0, 'textStyle', ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]);

        $section->addTextBreak();

        $section->addText("Por favor, no dude en contactarse con nosotros en caso de cualquier duda o aclaración, que con gusto atenderemos sus comentarios.", 'textStyle');

//        $section->addText(PHP_EOL);

        $section->addText("Atentamente,", 'textStyle');

        $section->addText(PHP_EOL);

        // Incluir el nombre del usuario autenticado
        $section->addText($sellerName, ['bold' => true, 'highlightColor' => 'yellow']);

        // Guardar el documento de Word en un archivo temporal
        $fileName = 'quotation_' . $quotation->consecutive . '.docx';
        $path = storage_path("app/public/{$fileName}");

        // Guardar el documento como .docx
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($path);

        // Devolver el documento para su descarga
        return response()->download($path)->deleteFileAfterSend(true);
    }
}
