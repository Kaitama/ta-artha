<?php

namespace App\View\Components;

use App\Models\AbsenceValidation;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AbsenceCard extends Component
{

    public bool $checked_in = false;

    public bool $is_validated = false;

    public bool $is_late = false;

    public object|null $absence = null;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $absence = \Auth::user()->absences()->whereDate('created_at', Carbon::today())->first();

        $this->is_validated = AbsenceValidation::whereDate('for_date', Carbon::today())->exists();

        if ($absence) {
            $this->absence = $absence;
            $this->checked_in = true;
            $this->is_late = $absence->is_late;
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.absence-card');
    }

}
