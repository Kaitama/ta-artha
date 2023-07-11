<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;

class CashflowHistory extends Component
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
        $cashflows = \Auth::user()->cashflows()
            ->whereMonth('saved_at', $this->month)
            ->whereYear('saved_at', $this->year)
            ->latest()
            ->get();
        return view('livewire.components.cashflow-history', compact('cashflows'));
    }
}
