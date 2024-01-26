<div>
    <livewire:quotations.quotation-create wire:model="showCreateModal" />
    <h2 class="text-xl font-semibold mb-2">Lista de Cotizaciones:</h2>

    <ul>
        @foreach ($quotations as $quotation)
            <li>
                <strong>Proyecto:</strong> {{ $quotation->project->name }}<br>
                <strong>Cliente:</strong> {{ $quotation->client->name }}<br>
                <strong>Fecha de Cotización:</strong> {{ $quotation->quotation_date }}<br>
                <strong>Período de Validez:</strong> {{ $quotation->validity_period }} días<br>
                <strong>Monto Total de la Cotización:</strong> {{ $quotation->total_quotation_amount }}<br>
                <!-- Add other details of the quotation based on your fields -->
            </li>
        @endforeach
    </ul>
</div>
