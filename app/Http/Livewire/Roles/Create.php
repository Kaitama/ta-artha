<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class Create extends Component
{
    public $nama_jabatan;

    public $potongan_absensi = 0;

    public $travel = 0;

    public $gaji_pokok = 0;

    public $rate = 0;

    public $tunjangan = 0;

    public function render()
    {
        return view('livewire.roles.create');
    }

    public function store()
    {
        $this->validate([
            'nama_jabatan' => 'required|unique:roles,name|string|max:255',
            'potongan_absensi' => 'required|integer|min:0',
            'travel' => 'required|integer|min:0',
            'gaji_pokok' => 'nullable|integer|min:0',
            'rate' => 'nullable|integer|min:0',
            'tunjangan' => 'nullable|integer|min:0',
        ]);

        Role::create([
            'name'  => $this->nama_jabatan,
            'absence_cut' => $this->potongan_absensi,
            'travel' => $this->travel,
            'base' => $this->gaji_pokok,
            'rate' => $this->rate,
            'bonus' => $this->tunjangan,
        ]);

        return to_route('roles.index')->success('Jabatan berhasil disimpan.');

    }
}
