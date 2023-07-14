<?php

namespace App\Http\Livewire\Cashflows;

use App\Models\Cashflow;
use Carbon\Carbon;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public Cashflow $cashflow;

    public $pegawai;

    public $limit_pinjaman;

    protected $validationAttributes = [
        'cashflow.saved_at' => 'tanggal',
        'cashflow.type' => 'tipe',
        'cashflow.description' => 'keterangan',
    ];

    public function mount()
    {
        $user = $this->cashflow->user;
        $this->pegawai = $user->name;
        $limit = $user->roles->first()->limit;
        $terpinjam = $user->cashflows()->whereMonth('saved_at', Carbon::now()->month)->whereNot('id', $this->cashflow->id)->sum('nominal');
        if ($limit > 0) {
            $this->limit_pinjaman = $limit - $terpinjam;
        }
    }

    protected function rules(): array
    {
        return [
            'cashflow.saved_at' => 'required',
            'cashflow.type' => 'required',
            'cashflow.nominal' => $this->limit_pinjaman ? 'required|integer|max:' . $this->limit_pinjaman : 'required|integer',
            'cashflow.description' => 'nullable|string|max:255',
        ];
    }

    public function render()
    {
        $types = (new Cashflow)->type_list;
        return view('livewire.cashflows.edit', compact('types'));
    }

    public function update()
    {
        $this->validate();
        $this->cashflow->save();
        Toaster::success('Pengeluaran berhasil diubah.');
    }
}
