<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use Livewire\Component;

class MaterialShow extends Component
{
    public $openShow = false;
    public $material;

    public function mount(Material $material)
    {
        $this->material = $material;
    }

    public function render()
    {
        return view('livewire.resources.materials.material-show');
    }
}
