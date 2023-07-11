<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    use WithPagination;

    public int $per_page = 10;

    public string $search = '';

    public $record_to_delete;

    public $show_delete_modal = false;

    public function render()
    {

        $s = '%' . $this->search . '%';
        $users = User::where(function($query) use ($s){
            return $query->where('name', 'like', $s)
                ->orWhere('nip', 'like', $s)
                ->orWhere('email', 'like', $s)
                ->orWhere('phone', 'like', $s)
                ->orWhere('username', 'like', $s);
        })
            ->latest()
            ->paginate($this->per_page);

        return view('livewire.users.index', compact('users'));
    }

    public function confirmDelete(User $user)
    {
        $this->record_to_delete = $user;
        $this->show_delete_modal = true;
    }

    public function destroy()
    {
        $this->record_to_delete->delete();
        $this->reset('show_delete_modal', 'record_to_delete');
        Toaster::success('Pegawai berhasil dihapus.');
    }
}
