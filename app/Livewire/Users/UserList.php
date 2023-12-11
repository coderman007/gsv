<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class UserList extends Component
{


    public function render()
    {
        return view('livewire.users.user-list');
    }
}
