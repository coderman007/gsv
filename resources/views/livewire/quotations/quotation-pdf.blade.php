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

        /* Estilos para la sección de flujos de caja */
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

        .cash-flow-title {
            text-align: center;
            font-weight: bold;
            padding: 10px 0;
            font-size: 18px;
        }

        .cash-flow-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .cash-flow-grid th, .cash-flow-grid td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        .cash-flow-grid th {
            background-color: #1f5d94;
            color: #fff;
        }

        .cash-flow-grid td {
            font-size: 14px;
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

    <!-- Sección de Variables Macroeconómicas -->
    <div class="section">
        <h2>Variables Macroeconómicas</h2>
        <p><strong>Índice de Precios al Consumidor:</strong> {{ $macroVars['Índice de Precios al Consumidor (IPC)'] }}%
        </p>
        <p><strong>Porcentaje de Impuesto sobre la Renta:</strong> {{ $macroVars['Impuesto sobre la Renta (IR)'] }}%</p>
        <p><strong>Incremento Anual del Costo de
                Energía:</strong> {{ $macroVars['Incremento Anual Costo Energía (IACE)'] }}%</p>
        <p><strong>Pérdida de Eficiencia del Sistema
                Solar:</strong> {{ $macroVars['Pérdida Eficiencia Sistema Fotovoltaico (PESF)'] }}%</p>
        <p><strong>Costo de Mantenimiento Anual:</strong> {{ $macroVars['Costo Mantenimiento Anual (CMA)'] }}%</p>
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

        <!-- Ahorro por Autoconsumo -->
        <div class="cash-flow-title">Ahorro por Autoconsumo</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)$cashFlow->income_autoconsumption[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
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
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->tax_discount, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
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
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accelerated_depreciation, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accelerated_depreciation, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- OPEX -->
        <div class="cash-flow-title">OPEX</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->opex, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
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
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->maintenance_cost, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->maintenance_cost, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- Flujo de Caja -->
        <div class="cash-flow-title">Flujo de Caja</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->cash_flow, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->cash_flow, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>

        <!-- Flujo de Caja Acumulado -->
        <div class="cash-flow-title">Flujo de Caja Acumulado</div>
        <table class="cash-flow-grid">
            <tr>
                <th>Año</th>
                @for ($i = 1; $i <= 13; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accumulated_cash_flow, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
            <tr>
                <th>Año</th>
                @for ($i = 14; $i <= 25; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
            <tr>
                <td>Valor</td>
                @for ($i = 13; $i < 25; $i++)
                    <td>{{ number_format((float)json_decode($cashFlow->accumulated_cash_flow, true)[$i], 2, ',', '.') }}</td>
                @endfor
            </tr>
        </table>
    </div>


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
