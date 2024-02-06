<?php

namespace App\Livewire\ProjectTypes;

use App\Models\ProjectType;
use Livewire\Component;

class ProjectTypeShow extends Component
{
    public $openShow = false;
    public $type;

    public function mount(ProjectType $type)
    {
        $this->type = $type;
    }
    public function render()
    {
        return view('livewire.project-types.project-type-show');
    }
}
