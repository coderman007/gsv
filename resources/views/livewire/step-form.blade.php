<div>
    <ul class="flex" id="myTab" role="tablist">
        <li class="mr-1" role="presentation">
            <button wire:click="showStep(1)" class="bg-blue-500 text-white px-4 py-2 rounded-t-lg" type="button">
                Información del Cliente
            </button>
        </li>
        <li class="mr-1" role="presentation">
            <button wire:click="showStep(2)" class="bg-blue-500 text-white px-4 py-2" type="button">
                Información del Proyecto
            </button>
        </li>
        <li role="presentation">
            <button wire:click="showStep(3)" class="bg-blue-500 text-white px-4 py-2 rounded-b-lg" type="button">
                Información Complementaria
            </button>
        </li>
    </ul>

    <div class="bg-gray-200 p-4" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <!-- Contenido del Paso 1 -->
            @if($currentStep == 1)
            @livewire('step-one-form')
            @endif
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <!-- Contenido del Paso 2 -->
            @if($currentStep == 2)
            @livewire('step-two-form')
            @endif
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <!-- Contenido del Paso 3 -->
            @if($currentStep == 3)
            @livewire('step-three-form')
            @endif
        </div>
    </div>
</div>