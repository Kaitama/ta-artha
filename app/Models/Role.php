<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends \Spatie\Permission\Models\Role
{
    //
    protected $appends = [
        'display_name',
    ];

    public function name(): Attribute
    {
        return Attribute::make(
//            get: fn(string $value) => ucwords(str_replace('-', ' ', $value)),
            set: fn(string $value) => strtolower(str_replace([' ', '_'], '-', $value))
        );
    }

    public function displayName(): Attribute
    {
        return Attribute::make(
            get: fn() => ucwords(str_replace('-', ' ', $this->name)),
        );
    }
}
