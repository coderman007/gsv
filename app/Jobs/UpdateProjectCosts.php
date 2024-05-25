<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Position;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProjectCosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $positionId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($positionId)
    {
        $this->positionId = $positionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $projects = Project::whereHas('positions', function ($query) {
            $query->where('position_id', $this->positionId);
        })->get();

        foreach ($projects as $project) {
            $project->recalculateLaborCost();
            $project->recalculateTotalCost();
            $project->save();
        }
    }
}
