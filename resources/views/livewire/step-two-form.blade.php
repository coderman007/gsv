<div>
    {{-- Dropdown para listar los proyectos --}}

    <div class="relative">
        <select wire:model="selectedProject" id="selectedProject" name="selectedProject"
            class="mt-1 block w-full p-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
            <option value="" disabled>Selecciona un proyecto</option>
            @forelse ($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
            @empty
            <option value="">No se encontraron proyectos</option>
            @endforelse
        </select>
        @error('selectedProject') <span class="text-red-500">{{ $message }}</span> @enderror


    </div>