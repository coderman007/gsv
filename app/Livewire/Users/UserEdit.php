<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $openEdit = false;
    public $userId;
    public $name, $email, $password, $roles, $status = "";
    public $selectedRole;
    public $user;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'status' => 'required'
    ];

    public function mount($userId):void
    {
        try {
            $this->userId = $userId;
            $this->user = User::findOrFail($userId);
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->status = $this->user->status;
            $this->roles = Role::all();
        } catch (\Exception $exception) {
            abort(404, ['Usuario no encontrado', $exception->getMessage(),]);
        }
    }

    public function updateUser(): void
    {
        // Verificar si el usuario autenticado existe
        if (!auth()->check()) {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        // Verificar si el usuario autenticado tiene el rol 'Administrador' y está activo
        if (!auth()->user()->hasRole('Administrador') || auth()->user()->status !== 'Activo') {
            abort(403, 'No está autorizado para llevar a cabo esta acción.');
        }

        $this->validate();

        $user = User::findOrFail($this->userId);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? bcrypt($this->password) : $user->password,
            'status' => $this->status,
        ]);

        // Actualizar el rol del usuario si se ha seleccionado uno
        if ($this->selectedRole) {
            $user->syncRoles([$this->selectedRole]);
        }

        $this->openEdit = false;
        $this->dispatch('updatedUser', $user);
        $this->dispatch('updatedUserNotification');
    }

    public function render():View
    {
        return view('livewire.users.user-edit');
    }
}
