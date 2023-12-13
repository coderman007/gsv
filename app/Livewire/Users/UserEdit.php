<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Livewire\Component;

class UserEdit extends Component
{
    public $openEdit = false;
    public $user;
    public $name, $email, $password, $status;

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'status' => 'required'
    ];
    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->status = $user->status;
    }

    public function updateUser()
    {
        $validated = $this->validate();
        $user = $this->user->update($validated);
        $this->dispatch('updatedUser', $user);
        $this->openEdit = false;
        $this->reset('name', 'email', 'password', 'status');
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }
}
