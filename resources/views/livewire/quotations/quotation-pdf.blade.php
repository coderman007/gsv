<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización - {{ $quotation->consecutive }}</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 18px;
            background-color: #f4f6f9;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #1f5d94;
            color: #fff;
            padding: 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 180px;
            border-radius: 5px;
        }

        .header .quotation-info {
            flex: 1;
            text-align: center;
        }

        .header .quotation-info h1 {
            margin: 0;
            font-size: 36px;
        }

        .header .quotation-info p {
            margin: 5px 0;
            font-size: 20px;
        }

        .section {
            margin-bottom: 20px;
            padding: 20px;
            border-left: 6px solid #1f5d94;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .section h2 {
            font-size: 22px;
            color: #1f5d94;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #1f5d94;
            color: #fff;
            font-size: 16px;
        }

        .table td {
            font-size: 16px;
        }

        .total-row {
            background-color: #ecf0f1;
            font-weight: bold;
            color: #27ae60;
        }

        /* Ingresos */
        .income-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .income-section h2 {
            color: #27ae60;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Egresos */
        .expenses-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .expenses-section h2 {
            color: #e74c3c;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: #e74c3c solid 1px;
        }

        /* Estilos generales para la tabla de flujos de caja */
        .cash-flow-grid {
            width: 100%;
            border-collapse: separate; /* Cambiado a 'separate' para tener control sobre los bordes */
            border-spacing: 0 2px; /* Añade espacio entre las filas */
            margin-top: 10px;
        }

        .cash-flow-grid th, .cash-flow-grid td {
            border: 1px solid #a1a1a1; /* Bordes verdes para todas las celdas */
            padding: 10px;
            text-align: center;
            font-size: 14px;
            background-color: #ffffff; /* Fondo blanco */
        }

        /* Estilo para los encabezados */
        .cash-flow-grid th {
            background-color: #27ae60; /* Fondo verde */
            color: #fff; /* Texto blanco */
            font-weight: bold;
        }

        .table-green-border {
            background-color: #fff;
            border: 2px solid #27ae60;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 20px;
        }

        .table-red-border {
            background-color: #fff;
            border: 2px solid #ae272b;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 20px;
        }

        .cash-flow-grid th {
            background-color: #666;
            color: #fff;
        }

        .income-text {
            color: #27ae60;
            font-size: 14px;
        }

        .expenses-text {
            color: #ae2732;
            font-size: 14px;
        }

        .cash-flow-title {
            font-size: 20px;
            text-align: center;
            color: #666;
            padding: 20px;
            border-bottom: 1px solid #666;
        }

        /* Estilo para las secciones de cada subconjunto de años */
        .section-border {
            border: 2px solid #1f5d94; /* Borde azul alrededor de cada subconjunto */
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 10px;
        }

        /* Colores para valores negativos y positivos */
        .cash-flow-grid td.negative {
            color: red; /* Valores negativos en rojo */
        }

        .cash-flow-grid td.positive {
            color: green; /* Valores positivos en verde */
        }

        /* Opcional: fondo alterno para mejorar la lectura */
        .cash-flow-grid tr:nth-child(odd) td {
            background-color: #f4f6f9; /* Color de fondo alterno para las filas */
        }

        .cash-flow-grid tr:nth-child(even) td {
            background-color: #ffffff; /* Fondo blanco para las filas pares */
        }

        /* Footer */
        .footer {
            text-align: center;
            margin: 30px 0;
            font-size: 16px;
            color: #666;
            background-color: #ffffff;
            padding: 20px;
        }

        .footer a {
            color: #1f5d94;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <!-- Logotipo a la izquierda -->
        <img src="{{ public_path('images/logo_gsv.png') }}" alt="Logo de la Empresa">

        <!-- Información central de la cotización -->
        <div class="quotation-info">
            <h1>Cotización</h1>
            <p>Número: {{ $quotation->consecutive }}</p>
        </div>

        <!-- Información de fecha y validez a la derecha -->
        <div class="date-info">
            <p>Fecha: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') }}</p>
            <p>Validez: {{ $quotation->validity_period }} días</p>
        </div>
    </div>

    <div class="section">
        <h2>Detalles del Cliente</h2>
        <p><strong>Nombre:</strong> {{ $quotation->client->name }}</p>
        <p><strong>Ciudad:</strong> {{ $quotation->client->city->name }}</p>
    </div>

    <div class="section">
        <h2>Detalles del Proyecto</h2>
        <p><strong>Energía a Proveer:</strong> {{ $quotation->energy_to_provide }} kWh/mes</p>
        <p><strong>Número de Paneles:</strong> {{ $quotation->panels_needed }}</p>
        <p><strong>Transformador:</strong> {{ $quotation->transformer }} - {{ $quotation->transformerPower }} kW</p>
        <p><strong>Área Requerida:</strong> {{ $quotation->required_area }} m²</p>
        <p><strong>Costo por Kilowatt:</strong> ${{ $quotation->kilowatt_cost }}</p>
    </div>

    <!-- Detalles del Proyecto -->
    <div class="section">
        <h2>Detalles del Proyecto</h2>
        <p><strong>Capacidad del Proyecto:</strong> {{ $cashFlow->power_output }} kW</p>
        <p><strong>Inversión CAPEX:</strong> ${{ number_format($cashFlow->capex, 2) }}</p>
        <p><strong>Costo por kWh:</strong> ${{ number_format($cashFlow->energy_cost, 2) }}</p>
    </div>

    <!-- Energía Generada -->
    <div class="section">
        <h2>Energía Generada</h2>
        <p><strong>Energía Anual Generada:</strong> {{ number_format($cashFlow->energy_generated_annual, 2) }} kWh</p>
        <p><strong>Costo Energía Anual:</strong>
            ${{ number_format($cashFlow->energy_generated_annual * $cashFlow->energy_cost, 2) }}</p>
        <p><strong>Energía Mensual Generada:</strong> {{ number_format($cashFlow->energy_generated_monthly, 2) }} kWh
        </p>
        <p><strong>Costo Energía Mensual:</strong>
            ${{ number_format($cashFlow->energy_generated_monthly * $cashFlow->energy_cost, 2) }}</p>
    </div>

{{--    <!-- Proyección de Precio y Energía Generada -->--}}
{{--    <div class="section">--}}
{{--        <h2>Proyección de Precio de Energía y Energía Generada</h2>--}}
{{--        <table class="table">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Año</th>--}}
{{--                @for ($i = 1; $i <= 25; $i++)--}}
{{--                    <th>{{ $i }}</th>--}}
{{--                @endfor--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr>--}}
{{--                <th>Proyección Precio Energía ($/kWh)</th>--}}
{{--                @foreach ($cashFlow->income_autoconsumption as $index => $value)--}}
{{--                    <td>${{ number_format($value, 2) }}</td>--}}
{{--                @endforeach--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <th>Energía Generada (kWh)</th>--}}
{{--                @foreach ($cashFlow->accumulated_cash_flow as $index => $value)--}}
{{--                    <td>{{ number_format($cashFlow->energy_generated_annual - $index * ($cashFlow->energy_generated_annual * $cashFlow->opex[$index] / 100), 2) }}--}}
{{--                        kWh--}}
{{--                    </td>--}}
{{--                @endforeach--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}

    <!-- Sección de Variables Macroeconómicas -->
    <div class="section">
        <h2>Variables Macroeconómicas</h2>
        <p><strong>Índice de Precios al
                Consumidor:</strong> {{ $macroVars['Índice de Precios al Consumidor (IPC)'] }}%</p>
        <p><strong>Porcentaje de Impuesto sobre la Renta:</strong> {{ $macroVars['Impuesto sobre la Renta (IR)'] }}%
        </p>
        <p><strong>Incremento Anual del Costo de
                Energía:</strong> {{ $macroVars['Incremento Anual Costo Energía (IACE)'] }}%</p>
        <p><strong>Pérdida de Eficiencia del Sistema
                Solar:</strong> {{ $macroVars['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] }}%</p>
        <p><strong>Costo de Mantenimiento Anual:</strong> {{ $macroVars['Costo Mantenimiento Anual (CMA)'] }}%</p>
    </div>

    {{--    <div class="section">--}}
    {{--        <h2>Costos</h2>--}}
    {{--        <table class="table">--}}
    {{--            <tr>--}}
    {{--                <th>Descripción</th>--}}
    {{--                <th>Valor</th>--}}
    {{--            </tr>--}}
    {{--            <tr class="total-row">--}}
    {{--                <td>Total</td>--}}
    {{--                <td>${{ $quotation->total }}</td>--}}
    {{--            </tr>--}}
    {{--        </table>--}}
    {{--    </div>--}}

    <!-- Sección de Flujos de Caja -->
    <div class="section">
        <h2>Flujos de Caja</h2>

        <!-- Ingresos -->
        <div class="income-section income-text">
            <h2>Ingresos</h2>

            <!-- Ahorro por Autoconsumo -->
            <div class="table-green-border">
                <div class="cash-flow-title">Ahorro por Autoconsumo</div>
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $incomeAutoconsumption = json_decode($cashFlow->income_autoconsumption, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 2; $i <= 11; $i++)
                            <td>$ {{ number_format($incomeAutoconsumption[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 11; $i <= 20; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $incomeAutoconsumption = json_decode($cashFlow->income_autoconsumption, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 12; $i <= 21; $i++)
                            <td>$ {{ number_format($incomeAutoconsumption[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 21; $i <= 25; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $incomeAutoconsumption = json_decode($cashFlow->income_autoconsumption, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 22; $i <= 26; $i++)
                            <td>$ {{ number_format($incomeAutoconsumption[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                </table>
            </div>

            <!-- Descuento de Renta -->
            <div class="table-green-border">
                <div class="cash-flow-title">Descuento de Renta</div>
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $taxDiscount = json_decode($cashFlow->tax_discount, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 2; $i <= 11; $i++)
                            <td>$ {{ number_format($taxDiscount[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 11; $i <= 20; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $taxDiscount = json_decode($cashFlow->tax_discount, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 12; $i <= 21; $i++)
                            <td>$ {{ number_format($taxDiscount[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 21; $i <= 25; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $taxDiscount = json_decode($cashFlow->tax_discount, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 22; $i <= 26; $i++)
                            <td>$ {{ number_format($taxDiscount[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                </table>
            </div>

            <!-- Depreciación Acelerada -->
            <div class="table-green-border">
                <div class="cash-flow-title">Depreciación Acelerada</div>
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $acceleratedDepreciation = json_decode($cashFlow->accelerated_depreciation, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 2; $i <= 11; $i++)
                            <td>$ {{ number_format($acceleratedDepreciation[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 11; $i <= 20; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $acceleratedDepreciation = json_decode($cashFlow->accelerated_depreciation, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 12; $i <= 21; $i++)
                            <td>$ {{ number_format($acceleratedDepreciation[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 21; $i <= 25; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="income-section">
                        @php
                            $acceleratedDepreciation = json_decode($cashFlow->accelerated_depreciation, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 22; $i <= 26; $i++)
                            <td>$ {{ number_format($acceleratedDepreciation[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                </table>
            </div>
        </div>

        <!-- Egresos -->
        <div class="expenses-section expenses-text">
            <h2>Egresos</h2>

            <!-- Costo de operación y mantenimiento (OPEX) -->
            <div class="table-red-border">
                <div class="cash-flow-title">Operación y Mantenimiento (OPEX)</div>
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="expenses-section">
                        @php
                            $maintenanceCost = json_decode($cashFlow->maintenance_cost, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 2; $i <= 11; $i++)
                            @if($maintenanceCost[$i - 1] == 0)
                                <td>$ {{ number_format($maintenanceCost[$i - 1] ?? null) }}</td>
                            @else
                                <td>$ -{{ number_format($maintenanceCost[$i - 1] ?? null) }}</td>
                            @endif
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 11; $i <= 20; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="expenses-section">
                        @php
                            $maintenanceCost = json_decode($cashFlow->maintenance_cost, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 12; $i <= 21; $i++)
                            <td>$ -{{ number_format($maintenanceCost[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                    <br>
                    <tr>
                        <th>Año</th>
                        @for ($i = 21; $i <= 25; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr class="expenses-section">
                        @php
                            $maintenanceCost = json_decode($cashFlow->maintenance_cost, true);
                        @endphp
                        <th>Valor</th>
                        @for ($i = 22; $i <= 26; $i++)
                            <td>$ -{{ number_format($maintenanceCost[$i - 1] ?? null) }}</td>
                        @endfor
                    </tr>
                </table>
            </div>
        </div>
        <!-- Caja Libre y Flujo Acumulado -->
        <div class="section">
            <h2>Caja Libre y Flujo Acumulado</h2>
            <!-- Caja Libre -->
            <div class="cash-flow-title">Caja Libre</div>
            <table class="cash-flow-grid">
                <tr>
                    <th>Año</th>
                    @for ($i = 1; $i <= 10; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
                <tr>
                    <td>Valor</td>
                    @for ($i = 1; $i <= 10; $i++)
                        <td style="color: green;">
                            $ {{ number_format((float)json_decode($cashFlow->cash_flow, true)[$i]) }}</td>
                    @endfor
                </tr>
                <br>
                <tr>
                    <th>Año</th>
                    @for ($i = 11; $i <= 20; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
                <tr>
                    <td>Valor</td>
                    @for ($i = 11; $i <= 20; $i++)
                        <td style="color: green;">
                            $ {{ number_format((float)json_decode($cashFlow->cash_flow, true)[$i]) }}</td>
                    @endfor
                </tr>
                <br>
                <tr>
                    <th>Año</th>
                    @for ($i = 21; $i <= 25; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
                <tr>
                    <td>Valor</td>
                    @for ($i = 21; $i <= 25; $i++)
                        <td style="color: green;">
                            $ {{ number_format((float)json_decode($cashFlow->cash_flow, true)[$i]) }}</td>
                    @endfor
                </tr>
            </table>

            <!-- Flujo de Caja Acumulado -->
            <div class="cash-flow-title">Flujo de Caja Acumulado</div>

            <!-- Primera sección (Años 1-10) -->
            <div class="section-border">
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 1; $i <= 10; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr>
                        <td>Valor</td>
                        @php
                            $accumulatedCashFlow = json_decode($cashFlow->accumulated_cash_flow, true);
                        @endphp

                        @for ($i = 1; $i <= 10; $i++)
                            <td class="{{ $accumulatedCashFlow[$i] < 0 ? 'negative' : 'positive' }}">
                                $ {{ number_format((float)$accumulatedCashFlow[$i]) }}
                            </td>
                        @endfor
                    </tr>
                </table>
            </div>

            <!-- Segunda sección (Años 11-20) -->
            <div class="section-border">
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for ($i = 11; $i <= 20; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr>
                        <td>Valor</td>
                        @for ($i = 11; $i <= 20; $i++)
                            <td class="{{ $accumulatedCashFlow[$i] < 0 ? 'negative' : 'positive' }}">
                                $ {{ number_format((float)$accumulatedCashFlow[$i]) }}
                            </td>
                        @endfor
                    </tr>
                </table>
            </div>

            <!-- Tercera sección (Años 21-25) -->
            <div class="section-border">
                <table class="cash-flow-grid">
                    <tr>
                        <th>Año</th>
                        @for($i = 21; $i <= 25; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                    <tr>
                        <td>Valor</td>
                        @for ($i = 21; $i <= 25; $i++)
                            <td class="{{ $accumulatedCashFlow[$i] < 0 ? 'negative' : 'positive' }}">
                                $ {{ number_format((float)$accumulatedCashFlow[$i]) }}
                            </td>
                        @endfor
                    </tr>
                </table>
            </div>

        </div>
    </div>

    <div class="footer">
        <p>Gracias por su preferencia. Si tiene alguna pregunta, no dude en contactarnos.</p>
        <div class="footer-content">
            <div class="contact-info">
                <h3>Información de Contacto</h3>
                <p><strong>Teléfono:</strong> 3007187730</p>
                <p><strong>Dirección:</strong> Cra. 53A #5575 55-a, Fatima, Itagüí, Antioquia</p>
                <p><strong>Correo:</strong> <a href="mailto:gsv@mail.com">gsv@mail.com</a></p>
                <p><strong>Web:</strong> <a href="https://www.gsvingenieria.com/"
                                            target="_blank">gsvingenieria.com</a></p>
            </div>
            <div class="social-media">
                <h3>Síguenos en Redes Sociales</h3>
                <a href="https://www.facebook.com/gsvingenieria/" target="_blank">Facebook</a> |
                <a href="https://www.instagram.com/gsvingenieria/" target="_blank">Instagram</a> |
                <a href="https://co.linkedin.com/in/gsv-ingenieria-89278a169" target="_blank">LinkedIn</a>
            </div>
        </div>
    </div>
</div>
</body>

</html>
