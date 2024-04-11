<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;


class UserCreate extends Component
{
    public $openCreate = false;
    public $name, $email, $password, $roles;
    public $selectedRole = "";
    public $status = "";

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'status' => 'required'
    ];
    public function mount():void
    {
        $this->roles = Role::all();
    }
    public function createUser():void
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
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->status,
        ]);

        // Asignar un rol al usuario si se ha seleccionado uno
        if ($this->selectedRole) {
            $user->assignRole($this->selectedRole);
        }
        $this->openCreate = false;
        // session()->flash('message', 'Usuario Creado Satisfactoriamente!');
        // $message = session('message');
        $this->dispatch('createdUser', $user);
        $this->dispatch('createdUserNotification');
        $this->reset('name', 'email', 'password', 'status', 'selectedRole');
    }
    public function render():View
    {
        return view('livewire.users.user-create');
    }
}
