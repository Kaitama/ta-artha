<?php

namespace App\Http\Livewire\Cashflows;

use App\Models\Cashflow;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Create extends Component
{
    public $tanggal;

    public $roles;

    public $jabatan;

    public $pegawai;

    public $tipe;

    public $nominal;

    public $keterangan;

    public function mount()
    {
        $this->tanggal = Carbon::now()->format('Y-m-d');
        $this->roles = Role::all()->pluck('name');
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $types = (new Cashflow)->type_list;
        $users = User::whereHas('roles', fn($q) => $q->where('name', $this->jabatan))->get();
        return view('livewire.cashflows.create', compact('types', 'users'));
    }

    public function store()
    {
        $this->validate([
            'tanggal'   => 'required|date',
            'jabatan'   => 'required',
            'pegawai'   => 'required',
            'tipe'      => 'required',
            'nominal'   => 'required|integer|min:1000',
            'keterangan'=> 'nullable|string|max:255',
        ]);

        Cashflow::create([
            'saved_at' => $this->tanggal,
            'user_id' => $this->pegawai,
            'type' => $this->tipe,
            'nominal' => $this->nominal,
            'description' => $this->keterangan,
        ]);

        return to_route('cashflows.index')->success('Pengeluaran berhasil disimpan.');
    }
}
