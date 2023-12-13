<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-300 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />

                <!-- Aquí podrías tener el contenido de tu vista -->

                <x-delete-alert message="No podrás revertir esta acción!" type="warning" />

            </div>
        </div>
    </div>
</x-app-layout>
