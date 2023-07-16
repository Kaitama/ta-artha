<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsenceExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
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
        $absence = $row->absences->first();
        $status = 'Absen';
        if ($absence) $status = $absence->is_late ? 'Terlambat' : 'On Time';
        return [
            $this->no++,
            $row->nip,
            $row->name,
            $row->role_display_name,
            $row->check_in,
            $absence ? $absence->created_at->format('H:i') : null,
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIP/NUPTK',
            'NAMA PEGAWAI',
            'JABATAN',
            'JAM MASUK',
            'JAM CHECKIN',
            'STATUS',
        ];
    }
}
