<?php

namespace App\Livewire\Projects;

use App\Models\CommercialPolicy;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Component;

class ProjectShow extends Component
{
    public $project;
    public $openShow = false;

    public $internalCommissions;
    public $externalCommissions;
    public $margin;
    public $discount;

    public function mount($project): void
    {
        $this->project = $project;
        $this->internalCommissions = CommercialPolicy::where('name', 'like', 'internal_commissions')->first()?->percentage ?? 0;
        $this->externalCommissions = CommercialPolicy::where('name', 'like', 'external_commissions')->first()?->percentage ?? 0;
        $this->margin = CommercialPolicy::where('name', 'like', 'margin')->first()?->percentage ?? 0;
        $this->discount = CommercialPolicy::where('name', 'like', 'discount')->first()?->percentage ?? 0;

    }
        public function render(): View
    {
        return view('livewire.projects.project-show');
    }
}
