<?php

namespace App\Http\Livewire\Roster;

use App\Models\Roster;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $per_page = 10;

    public $search = '';

    public $show_delete_modal = false;

    public $record_to_delete = null;

    public $tahun_ajaran;

    public $semester;

    public function mount()
    {
        $this_month = Carbon::now()->month;
        if ($this_month <= 6) {
            $this->tahun_ajaran = Carbon::now()->addYears(-1)->year . '/' . Carbon::now()->year;
            $this->semester = 2;
        } else {
            $this->tahun_ajaran = Carbon::now()->year . '/' . Carbon::now()->addYear()->year;
            $this->semester = 1;
        }
    }

    public function render()
    {
        $s = '%' . $this->search . '%';

        $users = User::whereHas('roles', fn ($role) =>
            $role->where('name', 'guru-honor')
            )->where('is_active', true)
            ->where(fn ($user) => $user->where('name', 'like', $s)
                ->orWhere('nip', 'like', $s)
            )
            ->paginate($this->per_page);
        return view('livewire.roster.index', compact('users'));
    }

    public function confirmDelete(User $user)
    {
        $this->record_to_delete = $user;
        $this->show_delete_modal = true;
    }

    public function destroy()
    {
        $this->record_to_delete->teachinghours()->delete();
        $this->record_to_delete->rosters()->where('years', $this->tahun_ajaran)->where('semester', $this->semester)->delete();
        $this->show_delete_modal = false;
    }
}
