<?php

namespace App\Exports;

use App\Helpers\ExcelRupiah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Exception;

class PaymentExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithColumnFormatting, WithCustomValueBinder
{
    protected Collection $data;

    protected int $no = 1;

    public function __construct(Collection $collection)
    {
        $this->data = $collection;
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
        $bruto = ($row->base + $row->bonus + $row->travel - $row->withdraw - $row->absence_cut);
        $ten_percent = $bruto * 10 / 100;
        return [
            $this->no++,
            $row->user->nip,
            $row->user->name,
            $row->user->role_display_name,
            $row->point ?? '-',
            $row->hours ?? '-',
            $row->rate ?? '-',
            $row->base,
            $row->bonus,
            $row->travel,
            $row->withdraw,
            $row->absence,
            $row->absence_cut,
            $bruto,
            $ten_percent,
            $row->salary,
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIP/NUPTK',
            'NAMA PEGAWAI',
            'JABATAN',
            'POINT',
            'JAM',
            'RATE',
            'GAJI POKOK',
            'TUNJANGAN',
            'TRAVEL',
            'PINJAMAN/SOSIAL',
            'JUMLAH ABSEN',
            'POTONGAN ABSEN',
            'JUMLAH KOTOR',
            'PERSEPULUHAN',
            'JUMLAH DITERIMA',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'H' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'I' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'J' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'K' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'M' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'N' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'O' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
            'P' => ExcelRupiah::FORMAT_ACCOUNTING_IDR,
        ];
    }

    /**
     * @throws Exception
     */
    public function bindValue(Cell $cell, $value): bool
    {
        $numericalColumns = ['B'];
        if (in_array($cell->getColumn(), $numericalColumns)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

}
