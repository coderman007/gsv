<?php

namespace App\Livewire\ProjectCategories;

use App\Models\ProjectCategory;
use Livewire\Component;

class ProjectCategoryShow extends Component
{
    public $openShow = false;
    public $category;

    public function mount(ProjectCategory $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.project-categories.project-category-show');
    }
}
