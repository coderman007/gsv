<div>
    @foreach ($editingPositions as $positionId => $positionData)
        <div>
            <h3>Position ID: {{ $positionId }}</h3>

            @if ($positionData['showInputs'])
                <input type="text" wire:model="editingPositions.{{ $positionId }}.data.field1" />
                <input type="text" wire:model="editingPositions.{{ $positionId }}.data.field2" />
                <button wire:click="updatePosition({{ $positionId }})">Update</button>
            @else
                <p>Field 1: {{ $positionData['data']['field1'] }}</p>
                <p>Field 2: {{ $positionData['data']['field2'] }}</p>
                <button wire:click="toggleInputs({{ $positionId }})">Edit</button>
            @endif
        </div>
    @endforeach
</div>
