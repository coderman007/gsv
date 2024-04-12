<?php

namespace App\Livewire\Resources\Materials;

use App\Models\Material;
use Illuminate\View\View;
use Livewire\Component;

class MaterialShow extends Component
{
    public $openShow = false;
    public $material;

    public function mount(Material $material): void
    {
        $this->material = $material;
    }

    public function render(): View
    {
        return view('livewire.resources.materials.material-show');
    }
}
