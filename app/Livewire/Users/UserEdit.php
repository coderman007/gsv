<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserEdit extends Component
{
    public $openEdit = false;
    public $userId;
    public $name, $email, $password, $status = "";

    protected $rules = [
        'name' => 'required|min:5|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
        'status' => 'required'
    ];

    public function mount($userId)
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
    }

    public function updateUser()
    {
        
        $this->validate();

        $user = User::findOrFail($this->userId);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? bcrypt($this->password) : $user->password,
            'status' => $this->status,
        ]);

        $this->openEdit = false;
        $this->dispatch('updatedUser', $user);
        $this->dispatch('updatedUserNotification');
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }
}

