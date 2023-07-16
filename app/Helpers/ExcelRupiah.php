<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcelRupiah extends NumberFormat
{
    const FORMAT_ACCOUNTING_IDR = '_("Rp"* #,##0_);_("Rp"* \(#,##0\);_("Rp"* "-"??_);_(@_)';
    const FORMAT_TIME24 = 'H:mm';
}
