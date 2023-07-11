<?php

namespace App\Http\Livewire\Cashflows;

use App\Models\Cashflow;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public Cashflow $cashflow;

    public $pegawai;

    protected $validationAttributes = [
        'cashflow.saved_at' => 'tanggal',
        'cashflow.type' => 'tipe',
        'cashflow.description' => 'keterangan',
    ];

    public function mount()
    {
        $this->pegawai = $this->cashflow->user->name;
    }

    protected function rules(): array
    {
        return [
            'cashflow.saved_at' => 'required',
            'cashflow.type' => 'required',
            'cashflow.nominal' => 'required|integer|min:1000',
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
