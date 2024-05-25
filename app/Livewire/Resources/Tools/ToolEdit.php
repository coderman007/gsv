<?php

namespace App\Livewire\Resources\Tools;

use App\Events\ToolUpdated;
use App\Models\Tool;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property mixed|null $tool
 */
class ToolEdit extends Component
{
    use WithFileUploads;

    public $toolId;
    public $openEdit = false;
    public $name, $unitPricePerDay, $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'unitPricePerDay' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ];

    public function mount($toolId): void
    {
        $this->toolId = $toolId;
        $tool = Tool::findOrFail($toolId);
        $this->name = $tool->name;
        $this->unitPricePerDay = $tool->unit_price_per_day;
    }

    public function updateTool(): void
    {
        $this->validate();

        $tool = Tool::findOrFail($this->toolId);
        $tool->update([
            'name' => $this->name,
            'unit_price_per_day' => $this->unitPricePerDay,
        ]);

        if ($this->image) {
            Storage::delete($tool->image); // Elimina la imagen anterior si existe
            $imagePath = $this->image->store('tools', 'public');
            $tool->image = $imagePath;
            $tool->save();
        }

        // Emitir el evento después de actualizar la herramienta
        event(new ToolUpdated($tool));

        $this->openEdit = false;
        $this->dispatch('updatedTool', $tool);
        $this->dispatch('updatedToolNotification');
    }

    public function render(): View
    {
        $tool = Tool::findOrFail($this->toolId);
        return view('livewire.resources.tools.tool-edit', compact('tool'));
    }
}
