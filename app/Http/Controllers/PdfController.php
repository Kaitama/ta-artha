<?php

namespace App\Http\Controllers;

use App\Models\AbsenceValidation;
use App\Models\Payment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function paycheck(User $user, $month, $year)
    {
        $check = $user->payments()->where('month', $month)->where('year', $year)->first();
        $pdf = Pdf::loadView('pdf.paycheck', ['user' => $user, 'check' => $check, 'month' => $month, 'year' => $year]);
        return $pdf->stream('SLIP_GAJI ' . $month . '_' . $year . '.pdf');
    }
}
