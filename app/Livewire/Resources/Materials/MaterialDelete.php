<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialDelete extends Component
{
    public $openDelete = false;
    public $material;

    public function mount(Material $material): void
    {
        $this->material = $material;
    }

    public function deleteMaterial(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        // Si el material a eliminar existe, proceder con la eliminación
        if ($this->material) {
            $material = $this->material->delete();
            $this->dispatch('deletedMaterial', $material);
            $this->dispatch('deletedMaterialNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.materials.material-delete');
    }
}
