<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    use WithPagination;

    public $search;

    public $per_page = 10;

    public $record_to_delete;

    public $show_delete_modal = false;

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')
            ->paginate($this->per_page);
        return view('livewire.roles.index', compact('roles'));
    }

    public function confirmDelete(Role $role)
    {
        $this->record_to_delete = $role;
        $this->show_delete_modal = true;
    }

    public function destroy()
    {
        $this->record_to_delete->delete();
        $this->reset('show_delete_modal', 'record_to_delete');
        Toaster::success('Jabatan berhasil dihapus.');
    }
}
