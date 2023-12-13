<?php

namespace App\Livewire\Users;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;


class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $perSearch = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }


    #[Computed()]
    public function users()
    {
        return
            User::where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
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
}