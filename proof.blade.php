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
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .header {
            background-color: #1f5d94;
            color: #fff;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
            position: relative;
        }

        .header img {
            position: absolute;
            top: 20px;
            left: 20px;
            max-width: 120px;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
        }

        .header p {
            margin: 5px 0;
            font-size: 16px;
        }

        .section {
            margin-bottom: 20px;
            padding: 20px;
            border-left: 6px solid #1f5d94;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .section h2 {
            font-size: 24px;
            color: #1f5d94;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #1f5d94;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        .table th {
            background-color: #1f5d94;
            color: #fff;
            font-size: 18px;
        }

        .table td {
            font-size: 18px;
        }

        .total-row {
            background-color: #ecf0f1;
            font-weight: bold;
            color: #27ae60;
        }

        /* Colores y estilo para ingresos */
        .ingreso-section {
            background-color: #eafaf1;
            color: #27ae60;
            border: 2px solid #27ae60;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .ingreso-section h2 {
            color: #27ae60;
            font-size: 24px;
            text-align: center;
        }

        /* Colores y estilo para egresos */
        .egreso-section {
            background-color: #fdecea;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .egreso-section h2 {
            color: #e74c3c;
            font-size: 24px;
            text-align: center;
        }

        .cash-flow-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cash-flow-grid th, .cash-flow-grid td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 16px;
        }

        .cash-flow-grid th {
            background-color: #1f5d94;
            color: #fff;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin: 30px 0;
            font-size: 16px;
            color: #666;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer .contact-info, .footer .social-media {
            flex: 1;
            min-width: 250px;
        }

        .footer .contact-info p, .footer .social-media p {
            margin: 5px 0;
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
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/logo_gsv.png') }}" alt="Logo de la Empresa">
        <h1>Cotización</h1>
        <p>Número: {{ $quotation->consecutive }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') }}</p>
        <p>Validez: {{ $quotation->validity_period }} días</p>
    </div>

    <!-- Detalles del Cliente -->
    <div class="section">
        <h2>Detalles del Cliente</h2>
        <p><strong>Nombre:</strong> {{ $quotation->client->name }}</p>
        <p><strong>Ciudad:</strong> {{ $quotation->client->city->name }}</p>
    </div>

    <!-- Detalles del Proyecto -->
    <div class="section">
        <h2>Detalles del Proyecto</h2>
        <p><strong>Energía a Proveer:</strong> {{ $quotation->energy_to_provide }} kWh/mes</p>
        <p><strong>Número de Paneles:</strong> {{ $quotation->panels_needed }}</p>
        <p><strong>Transformador:</strong> {{ $quotation->transformer }} - {{ $quotation->transformerPower }} kW</p>
        <p><strong>Área Requerida:</strong> {{ $quotation->required_area }} m²</p>
        <p><strong>Costo por Kilowatt:</strong> ${{ $quotation->kilowatt_cost }}</p>
    </div>

    <!-- Variables Macroeconómicas -->
    <div class="section">
        <h2>Variables Macroeconómicas</h2>
        <p><strong>Índice de Precios al Consumidor:</strong> {{ $macroVars['Índice de Precios al Consumidor (IPC)'] }}%
        </p>
        <p><strong>Porcentaje de Impuesto sobre la Renta:</strong> {{ $macroVars['Impuesto sobre la Renta (IR)'] }}%</p>
        <p><strong>Incremento Anual del Costo de
                Energía:</strong> {{ $macroVars['Incremento Anual Costo Energía (IACE)'] }}%</p>
        <p><strong>Pérdida de Eficiencia del Sistema
                Solar:</strong> {{ $macroVars['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] }}%</p>
        <p><strong>Costo de Mantenimiento Anual:</strong>
            $ {{ number_format((float)$quotation->total * $macroVars['Costo Mantenimiento Anual (CMA)'] / 100)}} COP</p>
    </div>

    <!-- Ingresos -->
    <div class="ingreso-section">
        <h2>Ingresos</h2>

        <!-- Ahorro por Autoconsumo -->
        <div class="cash-flow-title">Ahorro por Autoconsumo</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr class="ingreso">
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)$cashFlow->income_autoconsumption[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- Descuento de Renta -->
        <div class="cash-flow-title">Descuento de Renta</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr class="ingreso">
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->tax_discount, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- Depreciación Acelerada -->
        <div class="cash-flow-title">Depreciación Acelerada</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr class="ingreso">
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accelerated_depreciation, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>
    </div>

    <!-- Egresos -->
    <div class="egreso-section">
        <h2>Egresos</h2>

        <!-- OPEX -->
        <div class="cash-flow-title">OPEX</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr class="egreso">
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->opex, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- Costo de Mantenimiento -->
        <div class="cash-flow-title">Costo de Mantenimiento</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr class="egreso">
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->maintenance_cost, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>
    </div>

    <!-- Flujo de Caja Acumulado -->
    <div class="section">
        <h2>Flujo de Caja Acumulado</h2>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accumulated_cash_flow, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Gracias por su preferencia. Si tiene alguna pregunta, no dude en contactarnos.</p>
        <div class="footer-content">
            <div class="contact-info">
                <h3>Información de Contacto</h3>
                <p><strong>Teléfono:</strong> 3007187730</p>
                <p><strong>Dirección:</strong> Cra. 53A #5575 55-a, Fatima, Itagüí, Antioquia</p>
                <p><strong>Correo:</strong> <a href="mailto:gsv@mail.com">gsv@mail.com</a></p>
                <p><strong>Web:</strong> <a href="https://www.gsvingenieria.com/" target="_blank">gsvingenieria.com</a>
                </p>
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


"{\"1\":1114184.4,\"2\":1795953.8343600002,\"3\":1929883.2559776,\"4\":2073747.2805141124,\"5\":2228278.2961382098,\"6\":2394262.2916668723,\"7\":2572542.7453848366,\"8\":2764024.793031007,\"9\":2969679.6947301016,\"10\":3190549.6220256533,\"11\":3427752.7876422205,\"12\":3682488.942176474,\"13\":3956045.2635952984,\"14\":4249802.667211205,\"15\":4565242.565718646,\"16\":4903954.110917127,\"17\":5267641.950926765,\"18\":5658134.539028076,\"19\":6077393.032739665,\"20\":6527520.824395329,\"21\":7010773.7473063655,\"22\":7529571.004607038,\"23\":8086506.871093056,\"24\":8684363.221787352,\"25\":9326122.94461774}"

<table class="cash-flow-grid">
    <tr>
        <th>Año</th>
        @for ($i = 1; $i <= 10; $i++)
            <th>{{ $i }}</th>
        @endfor
    </tr>
    <tr class="ingreso" style="margin-bottom: 10px;">
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
    <tr class="ingreso" style="margin-bottom: 10px;">
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
    <tr class="ingreso" style="margin-bottom: 10px;">
        @php
            $incomeAutoconsumption = json_decode($cashFlow->income_autoconsumption, true);
        @endphp
        <th>Valor</th>
        @for ($i = 22; $i <= 26; $i++)
            <td>$ {{ number_format($incomeAutoconsumption[$i - 1] ?? null) }}</td>
        @endfor
    </tr>
</table>

"{\"1\":1114184.4,\"2\":6931124.57706,\"3\":7045553.3502875995,\"4\":7168941.694014612,\"5\":1776789.5342887347,\"6\":1920199.0917249233,\"7\":2074776.3854457901,\"8\":2241370.115095008,\"9\":2420892.282897303,\"10\":2614322.8396012145,\"11\":2822714.6660965597,\"12\":3047198.91455353,\"13\":3288990.7345912075,\"14\":3549395.4117569095,\"15\":3829814.947491636,\"16\":4131755.111778766,\"17\":4456833.001831486,\"18\":4806785.142478034,\"19\":5183476.166362121,\"20\":5588908.114698906,\"21\":6025230.402125122,\"22\":6494750.492166732,\"23\":6999945.333030735,\"24\":7543473.606821915,\"25\":8128188.848904032}"
