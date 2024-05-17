<?php

namespace App\Livewire\Users;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use LaravelIdea\Helper\App\Models\_IH_Position_C;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\User;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';
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
    }

    #[Computed]
    public function users(): LengthAwarePaginator|_IH_Position_C|array
    {
        return User::where('users.id', 'like', '%' . $this->search . '%')
            ->orWhere('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('users.email', 'like', '%' . $this->search . '%')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', DB::raw('IFNULL(roles.name, "Sin Rol") as role_name'))
            ->orderBy($this->sortBy, $this->sortDirection)
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
