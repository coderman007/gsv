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
        if ($this->user) {
            $user = $this->user->delete();
            $this->dispatch('deletedUser', $user);
            $this->openDelete = false;
        }
    }
    public function render()
    {
        return view('livewire.users.user-delete');
    }
}
