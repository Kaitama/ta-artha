<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'is_active'])
    ->prefix('dashboard')
    ->group(function () {
        // Dashboard
        Route::get('/', function () { return view('dashboard'); })
            ->name('dashboard');

        // Checkin Absence
        Route::get('/checkin', [\App\Http\Controllers\AbsenceController::class, 'checkin'])
            ->name('absence.chekin');

        // Absences
        Route::get('/absences', \App\Http\Livewire\Absences\Index::class)
            ->name('absences.index')
            ->middleware(['permission:lihat-absensi']);


        // Payments
        Route::middleware(['permission:lihat-penggajian'])->prefix('payments')->group(function(){
            Route::get('/', \App\Http\Livewire\Payments\Index::class)
                ->name('payments.index');
            Route::get('/{user}/paycheck/{month}/{year}', [\App\Http\Controllers\PdfController::class, 'paycheck'])
                ->name('payments.paycheck');
        });

        // CashFlows
        Route::middleware(['permission:lihat-pengeluaran'])->prefix('cashflows')->group(function(){
            Route::get('/', \App\Http\Livewire\Cashflows\Index::class)
                ->name('cashflows.index');
            Route::get('/create', \App\Http\Livewire\Cashflows\Create::class)
                ->name('cashflows.create')
                ->middleware(['permission:buat-pengeluaran']);
            Route::get('/{cashflow}/edit', \App\Http\Livewire\Cashflows\Edit::class)
                ->name('cashflows.edit')
                ->middleware(['permission:ubah-pengeluaran']);
        });

        // Roles
        Route::middleware(['permission:lihat-jabatan'])->prefix('roles')->group(function(){
            Route::get('/', \App\Http\Livewire\Roles\Index::class)
                ->name('roles.index');
            Route::get('/create', \App\Http\Livewire\Roles\Create::class)
                ->name('roles.create')
                ->middleware(['permission:buat-jabatan']);
            Route::get('/{role}/edit', \App\Http\Livewire\Roles\Edit::class)
                ->name('roles.edit')
                ->middleware(['permission:ubah-jabatan']);
        });

        // Users
        Route::middleware(['permission:lihat-pegawai'])->prefix('users')->group(function(){
            Route::get('/', \App\Http\Livewire\Users\Index::class)
                ->name('users.index');
            Route::get('/create', \App\Http\Livewire\Users\Create::class)
                ->name('users.create')
                ->middleware(['permission:buat-pegawai']);
            Route::get('/{user}/edit', \App\Http\Livewire\Users\Edit::class)
                ->name('users.edit')
                ->middleware(['permission:ubah-pegawai']);
        });

    });
