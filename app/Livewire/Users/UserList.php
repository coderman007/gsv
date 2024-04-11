<?php

namespace App\Livewire\Users;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\View\View;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perSearch = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function order($sort): void
    {
        if ($this->sortBy == $sort) {
            $this->sortDirection = ($this->sortDirection == "desc") ? "asc" : "desc";
        } else {
            $this->sortBy = $sort;
            $this->sortDirection = "asc";
        }

        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        return User::where('users.id', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('users.email', 'like', '%' . $this->search . '%')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', DB::raw('IFNULL(roles.name, "Sin Rol") as role_name'))
            ->orderBy('role_name', $this->sortDirection)
            ->paginate($this->perSearch);
    }

    #[On('createdUser')]
    public function createdUser($user = null)
    {
    }

    #[On('updatedUser')]
    public function updatedUser($user = null)
    {
    }

    #[On('deletedUser')]
    public function deletedUser($user = null)
    {
    }

    public function render(): View
    {
        $users = $this->users();
        return view('livewire.users.user-list', compact('users'));
    }
}
