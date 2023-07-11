<?php
namespace App\Helpers;

class Rupiah {

    public static function format(int $nominal): string
    {
        return number_format($nominal, 0, ',', '.');
    }
}
