<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use Livewire\Component;

class MaterialDelete extends Component
{
    public $openDelete = false;
    public $material;

    public function mount(Material $material)
    {
        $this->material = $material;
    }

    public function deleteMaterial()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si el material a eliminar existe, proceder con la eliminación
        if ($this->material) {
            $material = $this->material->delete();
            $this->dispatch('deletedMaterial', $material);
            $this->dispatch('deletedMaterialNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.resources.materials.material-delete');
    }
}
