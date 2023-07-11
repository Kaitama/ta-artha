<?php

namespace App\Http\Livewire\Cashflows;

use App\Models\Cashflow;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public int $per_page = 10;

    public int $this_month;

    public int $this_year;

    public array $type_list;

    public int|null $type = null;

    public string $search = '';

    public object|null $record_to_delete;

    public bool $show_modal_delete = false;

    public function mount()
    {
        $this->this_month = Carbon::now()->month;
        $this->this_year = Carbon::now()->year;
        $this->type_list = (new Cashflow())->type_list;
    }

    public function render()
    {
        $s = '%' . $this->search . '%';

        $months = array_combine(
            range(1, 12),
            array_map(
                fn($month) => Carbon::create(null, $month)->monthName, range(1, 12)
            )
        );

        $flows = Cashflow::whereMonth('saved_at', $this->this_month)
            ->whereYear('saved_at', $this->this_year)
            ->where(fn($q) => $this->type ? $q->where('type', $this->type) : $q)
            ->whereHas('user', fn($q) => $q->where('name', 'like', $s)->orWhere('nip', 'like', $s))
            ->orderByDesc('saved_at')
            ->paginate($this->per_page);
        return view('livewire.cashflows.index', compact('flows', 'months'));
    }

    public function confirmDelete(Cashflow $cashflow)
    {
        $this->record_to_delete = $cashflow;
        $this->show_modal_delete = true;
    }

    public function destroy()
    {
        $this->record_to_delete->delete();
        $this->show_modal_delete = false;
        \Toaster::success('Pengeluaran berhasil dihapus.');
    }
}
