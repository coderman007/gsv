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
            font-size: 28px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
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
            border-bottom: 2px solid #1f5d94;
        }

        .section p {
            margin: 8px 0;
            font-size: 16px;
        }

        .section strong {
            color: #1f5d94;
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

        .footer {
            text-align: center;
            margin: 30px 0;
            font-size: 14px;
            color: #666;
            padding-top: 20px;
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

        .footer .contact-info,
        .footer .social-media {
            flex: 1;
            min-width: 250px;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .contact-info a {
            color: #1f5d94;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .social-media a {
            text-decoration: none;
            color: #1f5d94;
            margin: 0 10px;
        }

        .social-media a:hover {
            text-decoration: underline;
        }

        .footer .contact-info,
        .footer .social-media {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .footer .contact-info h3,
        .footer .social-media h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #1f5d94;
        }

        .cash-flow-section {
            margin-bottom: 20px;
            padding: 20px;
            border-left: 6px solid #1f5d94;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .cash-flow-section h2 {
            font-size: 22px;
            color: #1f5d94;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #1f5d94;
        }

        .cash-flow-section p {
            margin: 8px 0;
            font-size: 16px;
        }

        .cash-flow-table td {
            font-size: 16px;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ public_path('images/logo_gsv.png') }}" alt="Logo de la Empresa">
        <h1>Cotización</h1>
        <p>Número: {{ $quotation->consecutive }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') }}</p>
        <p>Validez: {{ $quotation->validity_period }} días</p>
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

    <div class="section">
        <h2>Costos</h2>
        <table class="table">
            <tr>
                <th>Descripción</th>
                <th>Valor</th>
            </tr>
            <tr class="total-row">
                <td>Total</td>
                <td>${{ $quotation->total }}</td>
            </tr>
        </table>
    </div>
    <!-- Sección de Flujos de Caja -->
    <div class="cash-flow-section">
        <h2>Flujos de Caja</h2>
        <table class="table cash-flow-table">

            <tr>
                <td><strong>CAPACIDAD DEL PROYECTO</strong></td>
                <td>{{ $quotation->project->power_output }} kWh/mes</td>
            </tr>

            <tr>
                <td><strong>INVERSION (CAPEX)</strong></td>
                <td>${{ number_format($cashFlow->capex, 2, ',', '.') }}</td>
            </tr>

            <tr>
                <td><strong>COSTO ENERGÍA</strong></td>
                <td>${{ number_format($cashFlow->energy_cost, 2, ',', '.') }} / kWh</td>
            </tr>

            <tr>
                <td><strong>ENERGÍA ANUAL GENERADA</strong></td>
                <td>{{ $cashFlow->energy_generated_annual }} kWh</td>
            </tr>

            <tr>
                <td><strong>COSTO ENERGÍA ANUAL GENERADA</strong></td>
                <td>${{ number_format(
                            $cashFlow->energy_generated_annual * ($cashFlow->energy_cost ?? 0) * 1, 0, '.', ',' ) }}
                </td>
            </tr>

            <tr>
                <td><strong>ENERGÍA MENSUAL GENERADA</strong></td>
                <td>{{ $cashFlow->energy_generated_monthly }} kWh</td>
            </tr>

            <tr>
                <td><strong>COSTO ENERGÍA MENSUAL GENERADA</strong></td>
                <td>${{ number_format(
                            ($cashFlow->energy_generated_annual * ($cashFlow->energy_cost ?? 0) * 1) / 12, 0, '.', ',' ) }}
                </td>
            </tr>

            <tr>
                <td><strong>CANTIDAD ENERGÍA A CONSUMIR</strong></td>
                <td>100 % Mensual</td>
            </tr>
            <tr>
                <td><strong>IPC</strong></td>
                <td>{{ number_format($cashFlow->loadMacroEconomicVariables()['Índice de Precios al Consumidor (IPC)'], 1, ',', '.') }}%</td>
            </tr>
            <tr>
                <td><strong>PORCENTAJE IMPUESTO SOBRE LA RENTA</strong></td>
                <td>{{ number_format($cashFlow->loadMacroEconomicVariables()['Impuesto sobre la Renta (IR)'], 1, ',', '.') }}%</td>
            </tr>
            <tr>
                <td><strong>INCREMENTO ANUAL COSTO ENERGÍA</strong></td>
                <td>{{ number_format($cashFlow->loadMacroEconomicVariables()['Incremento Anual Costo Energía (IACE)'], 1, ',', '.') }}%</td>
            </tr>
            <tr>
                <td><strong>PERDIDA EFICIENCIA SISTEMA SOLAR</strong></td>
                <td>{{ number_format($cashFlow->loadMacroEconomicVariables()['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'], 1, ',', '.') }}%</td>
            </tr>
            <tr>
                <td><strong>COSTO MANTENIMIENTO ANUAL</strong></td>
                <td>${{ number_format($cashFlow->maintenance_cost, 2, ',', '.') }}</td>
            </tr>

            <tr>
                <td><strong>MITIGACIÓN DE GEI</strong></td>
                <td>{{ number_format($cashFlow->mgei, 4, ',', '.') }} toneladas CO2</td>
            </tr>

            <tr>
                <td><strong>COMPENSACIÓN ARBÓREA</strong></td>
                <td>{{ number_format($cashFlow->ca, 4, ',', '.') }} árboles</td>
            </tr>
        </table>
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
            <p><strong>Web:</strong> <a href="https://www.gsvingenieria.com/" target="_blank">gsvingenieria.com</a></p>
        </div>
        <div class="social-media">
            <h3>Síguenos en Redes Sociales</h3>
            <a href="https://www.facebook.com/gsvingenieria/" target="_blank">Facebook</a> |
            <a href="https://www.instagram.com/gsvingenieria/" target="_blank">Instagram</a> |
            <a href="https://co.linkedin.com/in/gsv-ingenieria-89278a169" target="_blank">LinkedIn</a>
        </div>
    </div>
</div>

</body>
</html>
