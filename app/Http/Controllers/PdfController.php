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
        $kasir = User::whereHas('roles', fn($role) => $role->where('name', 'kasir'))->first()->name;
        $check = $user->payments()->where('month', $month)->where('year', $year)->first();
        $pdf = Pdf::loadView('pdf.paycheck', ['user' => $user, 'check' => $check, 'month' => $month, 'year' => $year, 'kasir' => $kasir]);
        return $pdf->setPaper([0, 0, 400, 530])->stream('SLIP_GAJI ' . $month . '_' . $year . '.pdf');
    }
}
