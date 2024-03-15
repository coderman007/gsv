<div class="grid grid-cols-2 gap-4">

    <!-- Nombre de la Empresa-->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Nombre de la
            Empresa</label>
        <input placeholder="Nombre de la Empresa" wire:model="name"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="name" />
    </div>

    <!-- NIT -->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">NIT</label>
        <input placeholder="NIT" wire:model="document"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="document" />
    </div>

    <!-- Email de la Empresa-->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Correo Electrónico</label>
        <input placeholder="Correo Electrónico" wire:model="email"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
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

    <!-- Teléfono de la Empresa-->
    <div class="space-y-2 w-full text-xs">
        <label class="text-lg font-semibold text-gray-600 py-2">Teléfono</label>
        <input placeholder="Teléfono" wire:model="phone"
            class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 my-2"
            required="required" type="text">
        <x-input-error for="phone" />
    </div>

    <!-- Estado-->
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
</div>
