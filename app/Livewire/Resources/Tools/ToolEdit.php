<?php

namespace App\Livewire\Resources\Tools;

use App\Events\ToolUpdated;
use App\Models\Tool;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        $this->validate();

        $tool = Tool::findOrFail($this->toolId);
        $tool->update([
            'name' => $this->name,
            'unit_price_per_day' => $this->unitPricePerDay,
        ]);

        if ($this->image) {
            // Elimina la imagen anterior si existe
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image);
            }
            // Almacenar la nueva imagen
            $imagePath = $this->image->store('tools', 'public');
            $tool->update(['image' => $imagePath]);
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
