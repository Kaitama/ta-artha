<?php

namespace App\Http\Livewire\Components;

use App\Models\AbsenceValidation;
use Carbon\Carbon;
use Livewire\Component;

class AbsenceHistory extends Component
{

    public $bulan;

    public $tahun;

    public $months;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
        $this->months = array_combine(
            range(1, 12),
            array_map(
                fn($month) => Carbon::create(null, $month)->monthName, range(1, 12)
            )
        );
    }

    public function render()
    {
        $validations = AbsenceValidation::whereMonth('for_date', $this->bulan)
            ->whereYear('for_date', $this->tahun)
            ->orderByDesc('for_date')
            ->get();
        foreach ($validations as $validation){
            $validation->absence = \Auth::user()
                ->absences()
                ->where('is_validated', true)
                ->whereDate('created_at', $validation->for_date)
                ->first();
        }

        return view('livewire.components.absence-history', compact('validations'));
    }
}
