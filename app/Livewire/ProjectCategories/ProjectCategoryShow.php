<?php

namespace App\Livewire\ProjectCategories;

use App\Models\ProjectCategory;
use Illuminate\View\View;
use Livewire\Component;

class ProjectCategoryShow extends Component
{
    public $openShow = false;
    public $category;

    public function mount(ProjectCategory $category): void
    {
        $this->category = $category;
    }

    public function render():View
    {
        return view('livewire.project-categories.project-category-show');
    }
}

