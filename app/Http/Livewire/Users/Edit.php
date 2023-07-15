<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public User $user;

    public $jam_mengajar = [];

    public $jabatan;

    public $require_point = false;

    public $require_hours = false;

    protected $validationAttributes = [
        'user.nip'     => 'nomor induk',
        'user.name'    => 'nama lengkap',
        'user.gender'  => 'jenis kelamin',
        'user.phone'   => 'telepon',
        'user.check_in'=> 'jam masuk',
        'user.hours'   => 'jam mengajar',
    ];

    protected $messages = [
        'jam_mengajar.required_if' => 'Jam mengajar wajib diisi apabila jabatan Guru Honor',
        'user.point.required_if' => 'Point wajib diisi apabila jabatan Guru Tetap, Kasir, atau Kepala Sekolah',
    ];

    public function mount()
    {
        if ($this->user->hasAnyRole('guru-tetap', 'kasir', 'kepala-sekolah')) $this->require_point = true;
        if ($this->user->hasAnyRole('guru-honor')) {
            $this->require_hours = true;
            foreach ($this->user->teachinghours as $hour) {
                $this->jam_mengajar[$hour->day] = $hour->hours;
            }
        }
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
            'user.gender' => 'required',
            'user.username'      => 'required|alpha_num|unique:users,username,' . $id,
            'user.email'         => 'required|email|unique:users,email,' . $id,
            'user.phone'        => 'nullable',
            'user.check_in'     => 'required|date_format:H:i',
            'user.point'         => 'required_if:require_point,true|integer',
            'jam_mengajar'  => 'required_if:require_hours,true',
            'jam_mengajar.*'=> 'nullable|integer',
            'user.is_active' => 'boolean',
            'user.description' => 'nullable|string'
        ];
    }

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
        return view('livewire.users.edit', [
            'roles'=>Role::all()->pluck('name'),
            'days' => $days,
            'role_exists' => $role_exists
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->user->hours = $this->require_hours ? array_sum($this->jam_mengajar) : 0;

        $this->user->save();

        $this->user->syncRoles($this->jabatan);

        if($this->require_hours) {
            $teaching_hours = [];
            foreach ($this->jam_mengajar as $i => $jam) {
                if ($jam > 0) {
                    $teaching_hours[] = [
                        'day'   => $i,
                        'hours' => $jam
                    ];
                }
            }
            $this->user->teachinghours()->delete();
            $this->user->teachinghours()->createMany($teaching_hours);
        }

        Toaster::success('Pegawai berhasil diubah.');
    }
}
