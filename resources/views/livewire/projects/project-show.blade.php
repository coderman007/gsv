<div class="relative inline-block text-center cursor-pointer group">
    <a href="#" wire:click="$set('openShow', true)">
        <i class="p-1 text-green-400 rounded hover:text-white hover:bg-green-500 fa-solid fa-eye"></i>
        <div class="absolute z-10 px-3 py-2 mb-2 text-center text-white bg-gray-700 rounded-lg opacity-0 pointer-events-none text-md group-hover:opacity-80 bottom-full -left-3">
            Ver
            <svg class="absolute left-0 w-full h-2 text-black top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
            </svg>
        </div>
    </a>

    <x-dialog-modal wire:model="openShow">
        <x-slot name="title">
        </x-slot>
        <x-slot name="content">
            <div class="md:px-5 pb-5">
                <div class="md:mx-6">
                    <h5 class="mb-4 text-3xl font-semibold tracking-tight text-center text-gray-900 dark:text-white">
                        {{ $project->project_name }}
                    </h5>
                    <div class="text-lg text-start">
                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Cliente:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->client->name }}</p>
                        </div>

                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Tipo:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->project_type }}</p>
                        </div>
                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Descripción:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->description }}</p>
                        </div>
                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Kilowatts Requeridos:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->required_kilowatts }}</p>
                        </div>

                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Fecha de Inicio:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->start_date }}</p>
                        </div>

                        <div class="mb-3">
                            <h1 class="ml-2 text-sm">Término Estimado:</h1>
                            <p class="p-2 bg-gray-200 rounded-md">{{ $project->expected_end_date }}</p>
                        </div>

                        <div>
                            @if ($project->status == 'Activo')
                            <h1 class="ml-2 text-sm">Estado:</h1>
                            <p class="p-2 text-gray-100 bg-green-500 rounded-md">{{ $project->status }}</p>
                            @else
                            <h1 class="ml-2 text-sm">Estado:</h1>
                            <p class="p-2 text-gray-100 bg-red-400 rounded-md">{{ $project->status }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <!-- Botón para cerrar el modal de detalles -->
            <div class="mx-auto">
                <x-secondary-button wire:click="$set('openShow_project', false)" class="text-gray-500 bg-gray-200 border border-gray-500 shadow-lg hover:shadow-gray-400 hover:bg-gray-500 hover:text-white">
                    Salir
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
