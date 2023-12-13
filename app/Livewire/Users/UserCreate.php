<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserCreate extends Component
{
    public $openCreate = false;
    public $name, $email, $password;
    public $status = "";

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'status' => 'required'
    ];
    public function createUser()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
        ]);

        $this->openCreate = false;
        // session()->flash('message', 'Usuario Creado Satisfactoriamente!');
        // $message = session('message');
        $this->dispatch('createdUser', $user);
        $this->reset('name', 'email', 'password', 'status');
    }
    public function render()
    {
        return view('livewire.users.user-create');
    }
}
