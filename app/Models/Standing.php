<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    protected function record(): Attribute
    {
        return Attribute::get(fn () =>
            "{$this->wins}-{$this->losses}-{$this->ties}"
        );
    }
}
