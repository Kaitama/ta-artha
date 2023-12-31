<?php

namespace App\Http\Livewire\Payments;

use App\Exports\PaymentExport;
use App\Models\AbsenceValidation;
use App\Models\Payment;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{

    public object $roles;

    public array $months;

    public int $month;

    public int $year;

    public string|null $search = '';

    public bool $show_modal_confirmation = false;

    public bool $show_modal_delete = false;

    public function mount()
    {
        $this->roles = Role::all()->pluck('name');
        $this->month = Carbon::today()->month;
        $this->year = Carbon::today()->year;
        $this->months = array_combine(
            range(1, 12),
            array_map(
                fn($month) => Carbon::create(null, $month)->monthName, range(1, 12)
            )
        );
    }

    public function render()
    {
        $s = '%' . $this->search . '%';
        $payments = Payment::where('month', $this->month)
            ->where('year', $this->year)
            ->whereHas('user', fn ($q) => $q->where('is_active', true)
                ->where(fn ($u) => $u->where('name', 'like', $s)
                    ->orWhere('nip', 'like', $s)
                )
            )->with('user')
            ->get();

        $validation_exists = AbsenceValidation::whereMonth('for_date', $this->month)->whereYear('for_date', $this->year)->exists();

        return view('livewire.payments.index', compact('payments', 'validation_exists'));
    }

    public function export()
    {
        $data = Payment::where('month', $this->month)
            ->where('year', $this->year)
            ->whereHas('user', fn ($q) => $q->where('is_active', true))
            ->get();
        return Excel::download(new PaymentExport($data), 'DATA_GAJI_'.$this->month.'_'.$this->year.'.xlsx');
    }

    public function paycheck()
    {
        $validations = AbsenceValidation::whereMonth('for_date', $this->month)
            ->whereYear('for_date', $this->year)->orderBy('for_date')->get();

        $users = User::where('is_active', true)
            ->whereMonth('joined_at', '<', Carbon::now()->month)
            ->whereHas('roles')
            ->get();


        // TODO fix payments calculation
        foreach ($users as $user) {
            $r = $user->roles->first();
            $absence = 0;
            $total_hours = 0;
            foreach ($validations as $validation){
                if(!$user->absences()->whereDate('created_at', $validation->for_date)->exists()){
                    $absence++;
                } else {
                    $this_month = Carbon::now()->month;
                    if ($this_month <= 6) {
                        $years = Carbon::now()->addYears(-1)->year . '/' . Carbon::now()->year;
                        $semester = 2;
                    } else {
                        $years = Carbon::now()->year . '/' . Carbon::now()->addYear()->year;
                        $semester = 1;
                    }
                    if ($user->rosters()->exists()) {
                        $day_int = $validation->for_date->getDaysFromStartOfWeek() + 1;
                        $teaching_hour = $user->rosters()
                            ->where('years', $years)
                            ->where('semester', $semester)
                            ->where('day', $day_int)
                            ->count();
//                        $total_hours += $teaching_hour->hours ?? 0;
                        $total_hours += $teaching_hour;
                    }
                }
            }

            $minus = $user->cashflows()
                ->whereMonth('saved_at', $this->month)
                ->whereYear('saved_at', $this->year)
                ->sum('nominal');
            $absence_cut = $absence * $r->absence_cut;
            $base = $user->hitungGaji($total_hours);
            $bruto = $base + $r->travel + $r->bonus - $minus - $absence_cut;
            $ten_percent = $bruto * 10 / 100;
            $temp_salary = $bruto - $ten_percent;
            $salary = max($temp_salary, 0);
            $user->payments()->create([
                'month' => $this->month,
                'year'  => $this->year,
                'point' => $user->point,
                'hours' => $total_hours,
                'rate'  => $r->rate,
                'base'  => $base,
                'travel'=> $r->travel,
                'bonus' => $r->bonus,
                'withdraw' => $minus,
                'absence' => $absence,
                'absence_cut' => $absence_cut,
                'salary'=> $salary,
            ]);
        }
        $this->show_modal_confirmation = false;
        \Toaster::success('Penggajian berhasil dibuat.');

    }

    public function destroyAll()
    {
        $payments = Payment::where('month', $this->month)->where('year', $this->year)->delete();
        $this->show_modal_delete = false;
        \Toaster::success('Data penggajian berhasil direset.');
    }
}
