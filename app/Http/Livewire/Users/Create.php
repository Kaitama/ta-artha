<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{

    public $jabatan;

    public $keterangan;

    public $nomor_induk;

    public $nama_lengkap;

    public $jenis_kelamin = true;

    public $username;

    public $email;

    public $telepon;

    public $jam_masuk;

    public $point = 0;

    public $jam_mengajar = [];

    public $require_point = false;

    public $require_hours = false;

    public $status = true;

    public function render()
    {
        $days = [];
        for ($i = 0; $i <= 4; $i++){
            $days[$i + 1] = Carbon::now()->startOf('week')->addDay($i)->dayName;
        }
        $role_exists = [
            'kepala-sekolah' => User::whereHas('roles', fn ($role) => $role->where('name', 'kepala-sekolah'))->exists(),
            'kasir' => User::whereHas('roles', fn ($role) => $role->where('name', 'kasir'))->exists(),
            'bendahara' => User::whereHas('roles', fn ($role) => $role->where('name', 'bendahara'))->exists(),
        ];
        return view('livewire.users.create', [
            'roles' => Role::all()->pluck('name'),
            'days' => $days,
            'role_exists' => $role_exists
        ]);
    }

    public function updatedJabatan($value)
    {
        $this->reset('require_point', 'require_hours');
        if ($value === 'guru-tetap' || $value === 'kasir' || $value === 'kepala-sekolah') $this->require_point = true;
        if ($value === 'guru-honor') $this->require_hours = true;
    }

    public function store()
    {
        $this->validate([
            'jabatan'  => 'required',
            'nomor_induk'   => 'required|unique:users,nip',
            'nama_lengkap'  => 'required',
            'username'      => 'required|alpha_num|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'jam_masuk'     => 'required|date_format:H:i',
            'point'         => 'required_if:require_point,true|integer',
            'jam_mengajar'  => 'required_if:require_hours,true',
            'jam_mengajar.*'=> 'nullable|integer'
        ], [
            'jam_mengajar.required_if' => 'Jam mengajar wajib diisi apabila jabatan Guru Honor',
            'point.required_if' => 'Point wajib diisi apabila jabatan Guru Tetap, Kasir, atau Kepala Sekolah',
        ]);

        $user = User::create([
            'nip'       => $this->nomor_induk,
            'check_in'  => $this->jam_masuk,
            'point'     => $this->point,
            'hours'     => $this->require_hours ? array_sum($this->jam_mengajar) : 0,
            'name'      => $this->nama_lengkap,
            'gender'    => $this->jenis_kelamin,
            'email'     => $this->email,
            'username'  => $this->username,
            'phone'     => $this->telepon,
            'password'  => \Hash::make('sdadvent2'),
            'is_active' => $this->status,
            'description' => $this->keterangan,
        ]);

        $user->assignRole($this->jabatan);

        if($this->require_hours) {
            $teaching_hours = [];
            foreach ($this->jam_mengajar as $i => $jam) {
                $teaching_hours[] = [
                    'day'   => $i,
                    'hours' => $jam
                ];
            }
            $user->teachinghours()->createMany($teaching_hours);
        }

        return to_route('users.index')->success('Pegawai berhasil disimpan.');
    }
}
