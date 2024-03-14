<div>

    <!-- Nombre -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Nombre</label>
        <input placeholder="Nombre" wire:model="name"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required" type="text">
        @error('name')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>

    <!-- Cédula -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Cédula</label>
        <input placeholder="Cédula" wire:model="document"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required" type="text">
        @error('document')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Correo Electrónico</label>
        <input placeholder="Correo Electrónico" wire:model="email"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required" type="email">
        @error('email')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>

    <!-- Dirección -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Dirección</label>
        <input placeholder="Dirección" wire:model="address"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required" type="text">
        @error('address')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>

    <!-- Teléfono -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Teléfono</label>
        <input placeholder="Teléfono" wire:model="phone"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required" type="text">
        @error('phone')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>

    <!-- Estado -->
    <div class="mb-3 space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Estado</label>
        <select wire:model="status"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
            required="required">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select>
        @error('status')
            <p class="text-red text-xs">{{ $message }}</p>
        @enderror
    </div>
</div>
