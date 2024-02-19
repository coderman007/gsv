<?php

namespace App\Livewire\Resources\Tools;

use App\Models\Tool;
use Livewire\Component;

class ToolDelete extends Component
{
    public $openDelete = false;
    public $tool;

    public function mount(Tool $tool)
    {
        $this->tool = $tool;
    }

    public function deleteTool()
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Si la herramienta a eliminar existe, proceder con la eliminación
        if ($this->tool) {
            $tool = $this->tool->delete();
            $this->dispatch('deletedTool', $tool);
            $this->dispatch('deletedToolNotification');
            $this->openDelete = false;
        }
    }

    public function render()
    {
        return view('livewire.resources.tools.tool-delete');
    }
}
