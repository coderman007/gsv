<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserShow extends Component
{
    public $openShow = false;
    public $user;
    public $role;

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->role = $user->roles->first(); // Obtiene el primer rol del usuario
    }

    public function render(): View
    {
        return view('livewire.users.user-show');
    }
}
