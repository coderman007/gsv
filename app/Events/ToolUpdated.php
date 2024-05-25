<?php

namespace App\Events;

use App\Models\Tool;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ToolUpdated
{
    use Dispatchable, SerializesModels;

    public Tool $tool;

    public function __construct(Tool $tool)
    {
        $this->tool = $tool;
    }
}
