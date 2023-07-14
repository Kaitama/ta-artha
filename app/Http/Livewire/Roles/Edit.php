<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public Role $role;

    public $nama_jabatan;

    public function mount()
    {
        $this->nama_jabatan = $this->role->display_name;
    }

    protected function rules(): array
    {
        return [
            'role.name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'role.absence_cut' => 'required|integer|min:0',
            'role.travel' => 'required|integer|min:0',
            'role.base' => 'nullable|integer|min:0',
            'role.rate' => 'nullable|integer|min:0',
            'role.bonus' => 'nullable|integer|min:0',
            'role.limit' => 'nullable|integer'
        ];
    }

    protected $validationAttributes = [
        'role.name' => 'nama jabatan',
        'role.absence_cut' => 'potongan absen',
        'role.travel' => 'travel',
        'role.base' => 'gaji pokok',
        'role.rate' => 'rate',
        'role.bonus' => 'tunjangan',
        'role.limit' => 'limit',
    ];

    public function render()
    {
        return view('livewire.roles.edit');
    }

    public function update()
    {
        $this->role->name = $this->nama_jabatan;
        $this->validate();
        $this->role->save();
        Toaster::success('Jabatan berhasil diubah.');
    }
}
