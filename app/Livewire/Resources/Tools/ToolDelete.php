<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Illuminate\View\View;
use Livewire\Component;

class ToolDelete extends Component
{
    public $openDelete = false;
    public $tool;

    public function mount(Tool $tool): void
    {
        $this->tool = $tool;
    }

    public function deleteTool(): void
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene permisos para actualizar la categoría
        if (!$user || (!$user->hasRole('Administrador'))) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
            return;
        }

        // Si la herramienta a eliminar existe, proceder con la eliminación
        if ($this->tool) {
            $tool = $this->tool->delete();
            $this->dispatch('deletedTool', $tool);
            $this->dispatch('deletedToolNotification');
            $this->openDelete = false;
        }
    }

    public function render(): View
    {
        return view('livewire.resources.tools.tool-delete');
    }
}
