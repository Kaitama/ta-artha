<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cashflow extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'saved_at'  => 'date:Y-m-d',
    ];

    public array $type_list = [
        1 => 'Pinjaman',
        2 => 'Sosial',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
