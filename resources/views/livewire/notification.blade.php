<div>
    <h1 class="text-red-900 text-2xl">Sweet Alert 2</h1>


    <x-button wire:click='save'>
        Guardar
    </x-button>


    <x-button>
        {{-- wire:click='delete'> --}}
        Eliminar
    </x-button>

</div>

<script>
    document.addEventListener('livewire:inizialized', => () {
        @this.on('swal', (event) => {
            const data = event;
            swal.fire({
                icon: data[0][icon]
                , title: data[0][title]
                , text: data[0][text]
            , });

        });
    });

</script>
