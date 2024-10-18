<?php

namespace App\Livewire\Quotations;

use App\Models\CashFlow;
use App\Models\Client;
use App\Models\Material;
use App\Models\Project;
use App\Models\Quotation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;


class QuotationCreate extends Component
{
    public $openCreate = false;
    public $clients;
    public $city;
    public $selectedClientId;
    public $newClientModal = false;
    public $project;
    public $projectName;
    public $consecutive;

    public $energy_client;
    public $solar_radiation_level;
    public $transformer;
    public $transformerPower;
    public $required_area;
    public $kilowatt_cost;
    public $quotation_date;
    public $validity_period;
    public $subtotal;
    public $total;
    public $panels_needed;
    public $errorMessage;

    protected $rules = [
        'selectedClientId' => 'required|exists:clients,id',
        'energy_client' => 'required|numeric|min:0',
        'transformer' => 'required|in:Trifásico,Monofásico',
        'transformerPower' => 'required|numeric|min:0',
        'required_area' => 'required|numeric|min:0',
        'kilowatt_cost' => 'required|numeric|min:0',
        'quotation_date' => 'required|date',
        'validity_period' => 'required|integer|min:1',
        'subtotal' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
    ];

    public function mount(): void
    {
        $this->clients = Client::all();
        $this->quotation_date = now();
        $this->validity_period = 30;
        $this->generateConsecutive();
    }

    public function createQuotation(): void
    {
        $this->validate();

        // Cálculo de la potencia requerida
        $requiredPowerOutput = ($this->energy_client / 30) / $this->solar_radiation_level;

        // Definir un margen de tolerancia
        $tolerance = 0.58;
        $minPowerOutput = $requiredPowerOutput;
        $maxPowerOutput = $requiredPowerOutput + $tolerance;

        // Buscar proyectos que se encuentren dentro del rango de potencia con tolerancia
        $project = Project::whereBetween('power_output', [$minPowerOutput, $maxPowerOutput])
            ->first();

        // Asignar el proyecto encontrado o mostrar un mensaje de error
        $this->project = $project;

        if (!$this->project) {
            $this->errorMessage = 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.';
            return;
        }

        // Resetear el mensaje de error si se encuentra un proyecto
        $this->errorMessage = null;

        // Crear la cotización
        $quotation = Quotation::create([
            'project_id' => $this->project->id,
            'client_id' => $this->selectedClientId,
            'consecutive' => $this->consecutive,
            'energy_client' => $this->energy_client,
            'transformer' => $this->transformer,
            'transformer_power' => $this->transformerPower,
            'required_area' => $this->required_area,
            'panels_needed' => $this->panels_needed,
            'kilowatt_cost' => $this->kilowatt_cost,
            'quotation_date' => $this->quotation_date,
            'validity_period' => $this->validity_period,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
        ]);

        // Crear instancia de CashFlow y cargar las variables macroeconómicas
        $cashFlow = new CashFlow();
        $macroVars = $cashFlow->loadMacroEconomicVariables();

        // 1. Cálculo de la Energía Anual Generada (EAG)
        $eag = $this->project->power_output * $this->solar_radiation_level * 365; // EAG = P * I * 365

        // 2. Cálculo de la Energía Mensual Generada (EMG)
        $emg = $eag / 12; // EMG = EAG / 12

        // 3. Proyección del precio de la energía durante los próximos 25 años
        $pea = [];
        $pea[1] = $quotation->kilowatt_cost; // Precio Energía Año 1
        for ($i = 2; $i <= 25; $i++) {
            $pea[$i] = $pea[$i - 1] * (1 + $macroVars['Incremento Anual Costo Energía (IACE)'] / 100); // Incremento anual del costo de energía (IACE)
        }

        // 4. Cálculo de la Mitigación de GEI (MGEI)
        $mgei = ($eag * 0.126) / 1000; // MGEI = (EAG * 0.126) / 1000

        // 5. Cálculo de la Compensación Arbórea (CA)
        $ca = ($mgei * 1000) / 12; // CA = (MGEI * 1000) / 12

        // 6. Proyección de la cantidad de energía generada (CEGA) durante los próximos 25 años
        $cega = [];
        $cega[1] = $eag * (8 / 12); // Energía Generada Año 1 (considerando 8 meses de operación)
        $cega[2] = $eag - ($eag * ($macroVars['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] / 100)); // Energía Generada Año 1 (considerando 8 meses de operación)
        for ($i = 3; $i <= 25; $i++) {
            $cega[$i] = $cega[$i - 1] - ($eag * ($macroVars['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] / 100)); // Pérdida de eficiencia anual (PESF)
        }

        // 7. Cálculo del ahorro por autoconsumo (AA)
        $aa = [];
        for ($i = 1; $i <= 25; $i++) {
            $aa[$i] = $cega[$i] * $pea[$i]; // Ahorro por autoconsumo = CEGA * PEA
        }

        // 8. Cálculo del Descuento de Renta (DR) dividido entre los años 2, 3 y 4
        $tax_discount = $quotation->total / 6; // 50% del CAPEX dividido en 3
        $dr = [];

        // Distribuir el descuento en los años 2, 3 y 4
        for ($i = 1; $i <= 25; $i++) {
            if ($i == 2 || $i == 3 || $i == 4) {
                $dr[$i] = $tax_discount; // Descuento de Renta distribuido proporcionalmente
            } else {
                $dr[$i] = 0; // No hay descuento en los otros años
            }
        }

        // 9. Cálculo de la depreciación acelerada (DA)
        $depreciation = ($quotation->total / 3) * ($macroVars['Impuesto sobre la Renta (IR)'] / 100); // DA = CAPEX / 3 * IR (Impuesto sobre la Renta)
        $da = [];

        for ($i = 1; $i <= 25; $i++) {
            if ($i == 2 || $i == 3 || $i == 4) {
                $da[$i] = $depreciation; // Distribuir la depreciación en partes iguales en los años 2, 3 y 4
            } else {
                $da[$i] = 0; // No hay depreciación en los demás años
            }
        }

        // 10. Cálculo de los costos de mantenimiento anuales (CMA) a partir del año 2
        $cma = []; // Inicializar array para almacenar costos de mantenimiento
        $cma[1] = 0; // En el año 1 no hay costo de mantenimiento

        // A partir del año 2, se empieza a calcular el costo de mantenimiento
        $cma[2] = $quotation->total * ($macroVars['Costo Mantenimiento Anual (CMA)'] / 100); // Costo mantenimiento anual en el año 2

        // Para los años 3 en adelante, el costo de mantenimiento se incrementa según el IPC
        for ($i = 3; $i <= 25; $i++) {
            $cma[$i] = $cma[$i - 1] * (1 + ($macroVars['Índice de Precios al Consumidor (IPC)'] / 100)); // Incremento basado en IPC
        }

        // 11. Cálculo de la caja libre (ingresos - egresos) para cada año
        $free_cash_flow = []; // Caja Libre

        for ($i = 1; $i <= 25; $i++) {
            // Ingresos: Ahorro por autoconsumo + Descuento de renta + Depreciación acelerada
            $income = $aa[$i] + ($dr[$i] ?? 0) + ($da[$i] ?? 0);

            // Egresos: Costos de mantenimiento anual (solo a partir del año 2)
            $expenses = $cma[$i] ?? 0;

            // Caja Libre: Ingresos - Egresos
            $free_cash_flow[$i] = $income - $expenses;
        }

        // 12. Cálculo del flujo acumulado para cada uno de los 25 años
        $accumulated_cash_flow = []; // Flujo acumulado

        // Año 1: Flujo acumulado = -CAPEX + Caja Libre Año 1
        $accumulated_cash_flow[1] = -$quotation->total + $free_cash_flow[1];

        // Años 2 a 25: Flujo acumulado = Flujo acumulado del año anterior + Caja Libre del año correspondiente
        for ($i = 2; $i <= 25; $i++) {
            $accumulated_cash_flow[$i] = $accumulated_cash_flow[$i - 1] + $free_cash_flow[$i];
        }

        // Ejemplo de flujos de caja (CAPEX negativo y flujos positivos anuales)
        $cashFlows = [-$quotation->total]; // Inversión inicial (CAPEX)
        for ($i = 1; $i <= 25; $i++) {
            $cashFlows[] = $free_cash_flow[$i]; // Añadir cada flujo de caja anual calculado previamente
        }

        // Calcular la TIR
        $tir = $this->calcularTIR($cashFlows);

        // Calcular el Payback Time
        $paybackTime = $this->calcularPaybackTime($accumulated_cash_flow);

        // Guardar datos del flujo de caja en la base de datos
        $cashFlow->fill([
            'quotation_id' => $quotation->id,
            'power_output' => $this->project->power_output,
            'capex' => $quotation->total,
            'energy_cost' => $quotation->kilowatt_cost,
            'energy_generated_annual' => $eag,
            'energy_generated_monthly' => $emg,
            'mgei' => $mgei,
            'ca' => $ca,
            'income_autoconsumption' => json_encode($aa), // Convertir a JSON
            'tax_discount' => json_encode($dr), // Convertir a JSON
            'accelerated_depreciation' => json_encode($da), // Convertir a JSON
            'opex' => json_encode($cma), // Convertir a JSON
            'maintenance_cost' => json_encode($cma), // Convertir a JSON
            'cash_flow' => json_encode($free_cash_flow), // Convertir a JSON
            'accumulated_cash_flow' => json_encode($accumulated_cash_flow), // Convertir a JSON
            'internal_rate_of_return' => $tir, // TIR calculada
            'payback_time' => $paybackTime, // Tiempo de pago calculado
        ])->save();

        // Call the function to save cash flow data to CSV
        $this->saveCashFlowToCSV($accumulated_cash_flow);

        $this->reset(['selectedClientId', 'energy_client', 'project', 'transformer', 'transformerPower', 'required_area', 'panels_needed', 'kilowatt_cost', 'quotation_date', 'validity_period', 'subtotal', 'total']);

        $this->generateConsecutive();
        $this->openCreate = false;
        $this->dispatch('createdQuotation', $quotation);
        $this->dispatch('createdQuotationNotification');
    }

    private function saveCashFlowToCSV(array $accumulatedCashFlow): void
    {
        $filePath = storage_path('app/cash_flow.csv'); // Especificar la ruta donde se guardará el archivo

        // Abrir el archivo para escritura
        $file = fopen($filePath, 'w');

        // Escribir el encabezado
        fputcsv($file, ['Year', 'Accumulated Cash Flow']);

        // Escribir los datos del flujo de caja acumulado
        foreach ($accumulatedCashFlow as $year => $cashFlow) {
            fputcsv($file, [$year, $cashFlow]);
        }

        // Cerrar el archivo
        fclose($file);

        // Ejecutar el script de Python
        $this->runPythonScript();
    }

    private function runPythonScript(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('app:run_python_script');
    }


    /**
     * Calcula la Tasa Interna de Retorno (TIR) dada una serie de flujos de caja.
     *
     * @param array $cashFlows Arreglo de flujos de caja (el primer valor debe ser la inversión inicial con signo negativo).
     * @param float $initialGuess Valor inicial de la tasa de retorno para la iteración (opcional).
     * @return float|null Retorna la TIR como porcentaje o null si no se puede calcular.
     */
    public function calcularTIR(array $cashFlows, float $initialGuess = 0.1): float|int|null
    {
        $precision = 1.0e-6; // Precisión deseada
        $maxIter = 1000; // Número máximo de iteraciones

        // Inicialización de variables
        $tir = $initialGuess;
        $iteration = 0;

        // Implementación del método de Newton-Raphson
        while ($iteration < $maxIter) {
            $npv = 0.0; // Valor presente neto
            $npvDerivative = 0.0; // Derivada del valor presente neto

            foreach ($cashFlows as $t => $cf) {
                $npv += $cf / pow(1 + $tir, $t);
                $npvDerivative -= $t * $cf / pow(1 + $tir, $t + 1);
            }

            // Si la derivada es cero, no se puede dividir, entonces se rompe el ciclo
            if ($npvDerivative == 0) {
                return null;
            }

            // Calcular el nuevo valor de la TIR
            $newTir = $tir - $npv / $npvDerivative;

            // Verificar si el nuevo valor está dentro de la precisión deseada
            if (abs($newTir - $tir) < $precision) {
                return $newTir * 100; // Convertir la TIR a porcentaje
            }

            // Actualizar la TIR y continuar iterando
            $tir = $newTir;
            $iteration++;
        }

        // Si no converge, retornar null
        return null;
    }

    /**
     * Calcula el Payback Time (Tiempo de Recuperación) dado un flujo de caja acumulado.
     *
     * @param array $accumulatedCashFlow Arreglo del flujo de caja acumulado por año.
     * @return float|null Retorna el Payback Time como un valor decimal (años) o null si no se puede calcular.
     */
    public function calcularPaybackTime(array $accumulatedCashFlow): float|null
    {
        // Si no hay valores en el flujo acumulado, no se puede calcular el payback time
        if (empty($accumulatedCashFlow)) {
            return null;
        }

        // Iterar sobre el flujo de caja acumulado para encontrar el primer año con un flujo positivo
        foreach ($accumulatedCashFlow as $year => $accumulated) {
            // Si el flujo acumulado es mayor o igual a cero, significa que se ha recuperado la inversión
            if ($accumulated >= 0) {
                // Verificar si es el primer año con flujo positivo
                if ($year == 1) {
                    return 1.0; // Retornar año 1 si se recupera en el primer año exacto
                }

                // Interpolación lineal para calcular el payback dentro del año si no es un número entero
                $previousYear = $year - 1;
                $previousAccumulated = $accumulatedCashFlow[$previousYear];

                if ($previousAccumulated < 0) {
                    // Calcular la fracción del año en la que se recupera la inversión
                    $yearFraction = abs($previousAccumulated) / ($accumulated - $previousAccumulated);

                    return $previousYear + $yearFraction; // Año anterior + fracción de recuperación
                }
            }
        }

        // Si no se alcanza un flujo positivo en los años evaluados, retornar null
        return null;
    }

    public function updatedEnergyClient(): void
    {
        if (is_null($this->selectedClientId)) {
            $this->addError('selectedClientId', 'Debe seleccionar un cliente antes de ingresar la energía a proveer.');
            return;
        }

        // Verifica si energy_client es nulo o no es un número
        if (empty($this->energy_client) || !is_numeric($this->energy_client)) {
            // Resetear los valores relacionados con la cotización
            $this->subtotal = 0;
            $this->total = 0;
            $this->project = null;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        if ($this->solar_radiation_level <= 0) {
            $this->addError('solar_radiation_level', 'El nivel de radiación solar debe ser mayor que cero. Seleccione un cliente válido para obtener este valor.');
            $this->subtotal = 0;
            $this->total = 0;
            $this->project = null;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        // Cálculo de la potencia requerida
        $requiredPowerOutput = ($this->energy_client / 30) / $this->solar_radiation_level;

        // Definir un margen de tolerancia
        $tolerance = 0.58;
        $minPowerOutput = $requiredPowerOutput;
        $maxPowerOutput = $requiredPowerOutput + $tolerance;

        // Buscar proyectos que se encuentren dentro del rango de potencia con tolerancia
        $project = Project::whereBetween('power_output', [$minPowerOutput, $maxPowerOutput])
            ->orderBy('power_output')
            ->first();

        $this->project = $project;

        if (!$project) {
            $this->errorMessage = 'No se encontró un proyecto adecuado para la cantidad de kilovatios ingresados.';
            $this->subtotal = 0;
            $this->total = 0;
            $this->projectName = '';
            $this->required_area = 0;
            $this->panels_needed = 0;
            return;
        }

        $this->errorMessage = null; // Resetear el mensaje de error si se encuentra un proyecto

        // Asignar valores del proyecto encontrado
        $this->projectName = $project->projectCategory->name . " de " . $project->power_output . " kW.";
        $this->required_area = $project->required_area;
        $this->subtotal = $project->raw_value;
        $this->total = $project->sale_value;

        // Buscar el material con referencia 'Módulo Solar'
        $material = Material::where('reference', 'Módulo Solar')->first();
        if ($material) {
            $description = $material->description;

            if (is_null($description) || $description === '') {
                $this->addError('energy_client', 'La descripción del material no puede estar vacía.');
                return;
            }

            if (!is_numeric($description)) {
                $this->addError('energy_client', 'La descripción del material debe ser un valor numérico.');
                return;
            }

            $panelPower = (float)$description; // Convertir 'description' a un valor numérico
            $this->panels_needed = ceil($requiredPowerOutput * 1000 / $panelPower); // Número de paneles requeridos
        } else {
            $this->addError('energy_client', 'No se encontró el material con referencia Módulo Solar.');
        }

        $this->transformer = null;
        $this->transformerPower = null;
    }


    public function showNewClientModal(): void
    {
        $this->newClientModal = true;
    }

    public function hideNewClientModal(): void
    {
        $this->newClientModal = false;
    }

    public function updateCityAndRadiation(): void
    {
        $client = Client::find($this->selectedClientId);

        if ($client) {
            $city = $client->city;

            if ($city) {
                $this->city = $city->name;
                $this->solar_radiation_level = $city->irradiance;
            } else {
                $this->addError('selectedClientId', 'El cliente seleccionado no tiene una ciudad asociada.');
                $this->solar_radiation_level = 0;
            }
        }
    }

    private function generateConsecutive(): void
    {
        // Obtener el último número de consecutivo de cotización
        $lastQuotation = Quotation::latest()->first();
        $consecutiveNumber = $lastQuotation ? $lastQuotation->id + 1 : 1;

        // Formatear el consecutivo según el estándar deseado
        $this->consecutive = 'PROY' . date('ymd') . '-' . str_pad($consecutiveNumber, 3, '0', STR_PAD_LEFT);
    }

    // app/Http/Livewire/Quotations/QuotationCreate.php

    public function getTotalFormattedProperty(): string
    {
        return number_format($this->total, 2, '.', ',');
    }


    public function render(): View
    {
        return view('livewire.quotations.quotation-create');
    }

    #[On('clientStored')]
    public function clientStored(): void
    {
        $this->clients = Client::all();
    }

    #[On('createdQuotation')]
    public function createdQuotation($quotation): void
    {
        redirect()->to('quotations');
    }
}
