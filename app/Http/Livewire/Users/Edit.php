<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public User $user;

    public $jabatan;

    public $require_point = false;

    public $require_hours = false;

    protected $validationAttributes = [
        'user.nip'     => 'nomor induk',
        'user.name'    => 'nama lengkap',
        'user.phone'   => 'telepon',
        'user.check_in'=> 'jam masuk',
        'user.hours'   => 'jam mengajar',
    ];

    protected $messages = [
        'user.hours.required_if' => 'Jam mengajar wajib diisi apabila jabatan Guru Honor',
        'user.point.required_if' => 'Point wajib diisi apabila jabatan Guru Tetap, Kasir, atau Kepala Sekolah',
    ];

    public function mount()
    {
        if ($this->user->hasAnyRole('guru-tetap', 'kasir', 'kepala-sekolah')) $this->require_point = true;
        if ($this->user->hasAnyRole('guru-honor')) $this->require_hours = true;
        $this->jabatan = $this->user->roles()->first()->name ?? null;
    }

    public function updatedJabatan($value)
    {
        $this->reset('require_point', 'require_hours');
        if ($value === 'guru-tetap' || $value === 'kasir' || $value === 'kepala-sekolah') $this->require_point = true;
        if ($value === 'guru-honor') $this->require_hours = true;
    }

    protected function rules(): array
    {
        $id = $this->user->id;
        return [
            'jabatan'  => 'required',
            'user.nip'   => 'required|unique:users,nip,' . $id,
            'user.name'  => 'required',
            'user.username'      => 'required|alpha_num|unique:users,username,' . $id,
            'user.email'         => 'required|email|unique:users,email,' . $id,
            'user.phone'        => 'nullable',
            'user.check_in'     => 'required|date_format:H:i',
            'user.point'         => 'required_if:require_point,true|integer',
            'user.hours'  => 'required_if:require_hours,true|integer',
            'user.is_active' => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.users.edit', ['roles'=>Role::all()->pluck('name')]);
    }

    public function update()
    {
        $this->validate();

        $this->user->save();

        $this->user->syncRoles($this->jabatan);

        Toaster::success('Pegawai berhasil diubah.');
    }
}
