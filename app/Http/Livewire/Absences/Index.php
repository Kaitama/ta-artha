<?php

namespace App\Http\Livewire\Absences;

use App\Exports\AbsenceExport;
use App\Models\Absence;
use App\Models\AbsenceValidation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    public $today;

    public $search = '';

    public $roles;

    public $jabatan;

    public $teks = 'Validasi disini';

    public $show_modal_confirm = false;

    public $show_modal_reset = false;

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

    public function export()
    {
        $validasi_exists = $this->checkValidasiExists();
        $data = User::whereHas('roles')
            ->where(fn ($user) => $validasi_exists ? $user : $user->where('is_active', true))
            ->with('absences', fn($query) => $query->whereDate('created_at', $this->today))
            ->orderBy('name')
            ->get();
        $date_string = Carbon::createFromFormat('Y-m-d', $this->today)->format('d_m_Y');
        return Excel::download(new AbsenceExport($data), 'DATA_ABSENSI_'.$date_string.'.xlsx');
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

    public function resetValidasi()
    {
        AbsenceValidation::where('for_date', $this->today)->first()->delete();
        Absence::whereDate('created_at', $this->today)->update([
            'is_validated' => false,
            'validated_at' => null,
        ]);

        $this->show_modal_reset = false;

        \Toaster::success('Validasi absensi berhasil di reset.');
    }

}
