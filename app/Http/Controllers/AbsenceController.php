<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    //
    public function checkin()
    {
        $user = \Auth::user();
        $check_in_time = Carbon::now()->format('H:i');
        $is_late = $check_in_time > $user->check_in;

        $user->absences()->create([
            'is_late' => $is_late,
            'is_validated' => false,
        ]);

        return back()->success('Checkin absen sukses di jam ' . $check_in_time . ' WIB.');
    }
}
