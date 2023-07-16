<?php

namespace App\Exports;

use App\Helpers\ExcelRupiah;
use App\Models\Cashflow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CashflowExport implements FromCollection, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    protected Collection $data;

    protected int $no = 1;

    public function __construct(Collection $cashflow)
    {
        $this->data = $cashflow;
    }
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return $this->data;
    }

    public function map($row): array
    {
        return [
            $this->no++,
            Date::dateTimeToExcel($row->saved_at),
            $row->user->nip,
            $row->user->name,
            $row->user->role_display_name,
            (new Cashflow)->type_list[$row->type],
            $row->nominal,
            $row->description ?? '-'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'TANGGAL',
            'NIP/NUPTK',
            'NAMA PEGAWAI',
            'JABATAN',
            'JENIS PENGELUARAN',
            'NOMINAL',
            'KETERANGAN'
        ];
    }

}
