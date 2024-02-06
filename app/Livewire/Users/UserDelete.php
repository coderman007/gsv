<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserDelete extends Component
{
    public $openDelete = false;
    public $user;


    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function deleteUser()
{
    // Verificar si el usuario autenticado existe
    if (!auth()->check()) {
        abort(403, 'No está autorizado para llevar a cabo esta acción.');
    }

    // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
    if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
        abort(403, 'No está autorizado para llevar a cabo esta acción.');
    }

    // Si el usuario a eliminar existe, proceder con la eliminación
    if ($this->user) {
        $user = $this->user->delete();
        $this->dispatch('deletedUser', $user);
        $this->dispatch('deletedUserNotification');
        $this->openDelete = false;
    }
}

    public function render()
    {
        return view('livewire.users.user-delete');
    }
}
