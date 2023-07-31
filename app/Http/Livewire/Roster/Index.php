<?php

namespace App\Http\Livewire\Roster;

use App\Models\Roster;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $per_page = 10;

    public $search = '';

    public function render()
    {
        $s = '%' . $this->search . '%';

        $users = User::whereHas('roles', fn ($role) =>
            $role->where('name', 'guru-honor')
//                ->orWhere('name', 'guru-tetap')
//                ->orWhere('name', 'kepala-sekolah')
            )->where('is_active', true)
            ->where(fn ($user) => $user->where('name', 'like', $s)
                ->orWhere('nip', 'like', $s)
            )
            ->paginate($this->per_page);
        return view('livewire.roster.index', compact('users'));
    }
}
