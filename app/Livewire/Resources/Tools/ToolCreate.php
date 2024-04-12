<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ToolCreate extends Component
{
    use WithFileUploads;

    public $openCreate = false;
    public $name, $unitPricePerDay, $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'unitPricePerDay' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ];


    public function createTool(): void
    {
        $this->validate();

        // Almacenar la imagen de la herramienta si se proporciona
        $image_url = null;
        if ($this->image) {
            $image_url = $this->image->store('tools', 'public');
        }

        $tool = Tool::create([
            'name' => $this->name,
            'unit_price_per_day' => $this->unitPricePerDay,
            'image' => $image_url,
        ]);

        $this->openCreate = false;

        // Emitir eventos
        $this->dispatch('createdTool', $tool);
        $this->dispatch('createdToolNotification');

        $this->reset('name', 'unitPricePerDay', 'image');
    }

    public function render(): View
    {
        return view('livewire.resources.tools.tool-create');
    }
}
