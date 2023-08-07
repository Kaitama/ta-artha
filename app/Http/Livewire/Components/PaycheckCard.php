<?php

namespace App\Http\Livewire\Components;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class PaycheckCard extends Component
{
    public array $months;

    public int $month;

    public int $year;

    public function mount()
    {
        $this->month = Carbon::now()->month;
        $this->year = Carbon::now()->year;

        $this->months = array_combine(
            range(1, 12),
            array_map(
                fn($month) => Carbon::create(null, $month)->monthName, range(1, 12)
            )
        );
    }

    public function render()
    {
        $paycheck = \Auth::user()->payments()->where('month', $this->month)->where('year', $this->year)->first();
        return view('livewire.components.paycheck-card', compact('paycheck'));
    }

    public function downloadPaycheck()
    {
        $user = \Auth::user();
        $kasir = User::whereHas('roles', fn($role) => $role->where('name', 'kasir'))->first()->name;
        $check = $user->payments()->where('month', $this->month)->where('year', $this->year)->first();
        $pdf = Pdf::setPaper([0, 0, 400, 530])->loadView('pdf.paycheck', ['user' => \Auth::user(), 'check' => $check, 'month' => $this->month, 'year' => $this->year, 'kasir' => $kasir])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            'SLIP GAJI ' . $this->months[$this->month] . ' ' . $this->year . '.pdf'
        );
    }
}
