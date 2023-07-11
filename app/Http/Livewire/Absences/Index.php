<?php

namespace App\Http\Livewire\Absences;

use App\Models\Absence;
use App\Models\AbsenceValidation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $today;

    public $search = '';

    public $roles;

    public $jabatan;

    public $teks = 'Validasi disini';

    public $show_modal_confirm = false;

    public function mount()
    {
        $this->roles = Role::all()->pluck('name');
        $this->today = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $s = '%' . $this->search . '%';

        $validasi_exists = $this->checkValidasiExists();

        $users = User::whereHas('roles', fn ($role) =>
                $this->jabatan ? $role->where('name', $this->jabatan) : $role
            )
            ->where(fn ($user) => $validasi_exists ? $user : $user->where('is_active', true))
            ->where(fn ($user) => $user->where('name', 'like', $s)->orWhere('nip', 'like', $s))
            ->with('absences', fn($query) => $query->whereDate('created_at', $this->today))
            ->orderBy('name')
            ->get();

        return view('livewire.absences.index', compact('validasi_exists', 'users'));
    }

    protected function checkValidasiExists()
    {
        return AbsenceValidation::whereDate('for_date', $this->today)->first();
    }

    public function prosesValidasi()
    {
        if($this->checkValidasiExists()) {
            \Toaster::error('Validasi sudah pernah dilakukan.');
        } else {
            // save absence validasi date
            $validasi = AbsenceValidation::create([
                'user_id' => auth()->id(),
                'for_date' => $this->today,
            ]);

            Absence::whereDate('created_at', $this->today)->update([
                'is_validated' => true,
                'validated_at' => $validasi->created_at,
            ]);

            $this->show_modal_confirm = false;

            \Toaster::success('Absensi berhasil divalidasi.');
        }
    }

}
