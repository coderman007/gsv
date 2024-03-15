 <!-- Selección de Materiales -->
 <div class="mb-4">
     <label class="block text-sm font-medium text-gray-700">Materiales</label>
     <select wire:model="selectedMaterials" multiple class="mt-1 p-2 block w-full border-gray-300 rounded-md">
         @foreach ($materials as $material)
             <option value="{{ $material->id }}">{{ $material->name }}</option>
         @endforeach
     </select>
 </div>

 <!-- Selección de Herramientas -->
 <div class="mb-4">
     <label class="block text-sm font-medium text-gray-700">Herramientas</label>
     <select wire:model="selectedTools" multiple class="mt-1 p-2 block w-full border-gray-300 rounded-md">
         @foreach ($tools as $tool)
             <option value="{{ $tool->id }}">{{ $tool->name }}</option>
         @endforeach
     </select>
 </div>

 <!-- Selección de Transporte -->
 <div class="mb-4">
     <label class="block text-sm font-medium text-gray-700">Transporte</label>
     <select wire:model="selectedTransport" class="mt-1 p-2 block w-full border-gray-300 rounded-md">
         <option value="">Seleccionar Transporte</option>
         @foreach ($transports as $transport)
             <option value="{{ $transport->id }}">{{ $transport->name }}</option>
         @endforeach
     </select>
 </div>

 <!-- Campos de Cantidad y Días Requeridos -->
 @foreach ($selectedPositions as $index => $positionId)
     <div wire:key="position-field-{{ $index }}">
         <label for="position-quantity-{{ $index }}" class="block text-sm font-medium text-gray-700">Cantidad de
             Posición
             {{ $index + 1 }}</label>
         <input wire:model="positionQuantities.{{ $index }}" type="number"
             id="position-quantity-{{ $index }}" name="positionQuantities[]"
             class="mt-1 p-2 block w-full border-gray-300 rounded-md">
         <label for="position-required-days-{{ $index }}"
             class="block mt-2 text-sm font-medium text-gray-700">Días requeridos para
             Posición {{ $index + 1 }}</label>
         <input wire:model="positionRequiredDays.{{ $index }}" type="number"
             id="position-required-days-{{ $index }}" name="positionRequiredDays[]"
             class="mt-1 p-2 block w-full border-gray-300 rounded-md">
         <button wire:click="removePosition({{ $index }})" class="text-red-500 mt-2 hover:text-red-700">Eliminar
             Posición</button>
     </div>
 @endforeach
