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
        'user.joined_at'=> 'tanggal masuk',
        'user.nip'     => 'nomor induk',
        'user.name'    => 'nama lengkap',
        'user.gender'  => 'jenis kelamin',
        'user.phone'   => 'telepon',
        'user.check_in'=> 'jam masuk',
        'user.hours'   => 'jam mengajar',
        'user.birthplace' => 'tempat lahir',
        'user.birthdate' => 'tanggal lahir',
        'user.religion'=> 'agama',
        'user.education' => 'pendidikan',
        'user.major'   => 'jurusan',
        'user.university'=> 'perguruan tinggi',
    ];

    protected $messages = [
        'jam_mengajar.required_if' => 'Jam mengajar wajib diisi apabila jabatan Guru Honor',
        'user.point.required_if' => 'Point wajib diisi apabila jabatan Guru Tetap, Kasir, atau Kepala Sekolah',
        '*.phone.min_digits' => ':Attribute minimal :min angka.',
        '*.phone.max_digits' => ':Attribute maksimal :max angka.',
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

        if ($value === 'guru-tetap' || $value === 'kepala-sekolah') $this->user->nip = '10';
        elseif ($value === 'guru-honor') $this->user->nip = '20';
        else $this->user->nip = '30';
    }

    protected function rules(): array
    {
        $id = $this->user->id;
        return [
            'jabatan'  => 'required',
            'user.joined_at'    => 'required|date',
            'user.nip'   => 'required|numeric|digits:6|unique:users,nip,' . $id,
            'user.name'  => 'required',
            'user.gender' => 'required',
            'user.username'      => 'required|alpha_num|unique:users,username,' . $id,
            'user.email'         => 'required|email|unique:users,email,' . $id,
            'user.phone'        => 'nullable|numeric|min_digits:10|max_digits:15',
            'user.check_in'     => 'required|date_format:H:i',
            'user.point'         => 'required_if:require_point,true|integer',
            'jam_mengajar'  => 'required_if:require_hours,true',
            'jam_mengajar.*'=> 'nullable|integer',
            'user.is_active' => 'boolean',
            'user.description' => 'nullable|string',
            'user.birthplace' => 'required',
            'user.birthdate' => 'required|date',
            'user.religion'=> 'required',
            'user.education' => 'required',
            'user.major'   => 'nullable',
            'user.university'=> 'required',
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

        $this->user->check_in = '08:00';

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
            foreach ($teaching_hours as $data) {
                if(!$this->user->teachinghours()->where('day', $data['day'])->where('hours', $data['hours'])->exists()) {
                    $this->user->rosters()->delete();
                    $this->user->teachinghours()->delete();
                    $this->user->teachinghours()->createMany($teaching_hours);
                }
            }
        }

        Toaster::success('Pegawai berhasil diubah.');
    }
}
