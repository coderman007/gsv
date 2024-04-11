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

    public function formatDescription($description, $maxCharsPerLine = 60): string
    {
        // Dividir el texto en líneas de acuerdo con el límite de caracteres
        return wordwrap($description, $maxCharsPerLine, "<br>\n", true);
    }

    public function render():View
    {
        return view('livewire.project-categories.project-category-show');
    }
}

