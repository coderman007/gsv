<div class="grid grid-cols-2 gap-4">

    <!-- Nombre -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Nombre</label>
        <input placeholder="Nombre" wire:model="name"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="name" />
    </div>

    <!-- Cédula -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Cédula</label>
        <input placeholder="Cédula" wire:model="document"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="document" />
    </div>

    <!-- Email -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Correo Electrónico</label>
        <input placeholder="Correo Electrónico" wire:model="email"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="email">
        <x-input-error for="email" />
    </div>

    <!-- Dirección -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Dirección</label>
        <input placeholder="Dirección" wire:model="address"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="address" />
    </div>

    <!-- Teléfono -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Teléfono</label>
        <input placeholder="Teléfono" wire:model="phone"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="phone" />
    </div>

    <!-- Estado -->
    <!-- Condicional para mostrar el campo de estado solo cuando sea edición -->
    @if ($this->isEditing)
        <div class="space-y-2 w-full text-xs">
            <label class="text-lg font-semibold text-gray-600 py-2">Estado</label>
            <select wire:model="status"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
                    required="required">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
            <x-input-error for="status" />
        </div>
    @endif
</div>
