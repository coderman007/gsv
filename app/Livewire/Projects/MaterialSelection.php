<?php

namespace App\Livewire\Projects;

use App\Models\Material;
use Livewire\Component;

class MaterialSelection extends Component
{
    // Materiales
    public $search = '';
    public $materials = [];
    public $selectedMaterials = [];

    public function updatedSearch()
    {
        $this->materials = [];
    }

    public function render()
    {
        // Solo realizar la búsqueda si se ha ingresado un término de búsqueda
        if (!empty($this->search)) {
            // Buscar materiales en la base de datos basados en el término de búsqueda
            $this->materials = Material::where('reference', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->with('materialCategory')
                ->get();
        }
        return view('livewire.projects.material-selection');
    }
}
