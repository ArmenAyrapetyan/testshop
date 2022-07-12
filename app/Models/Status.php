<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    const STATUS_SOLD = 1;
    const STATUS_HIDDEN = 2;
    const STATUS_SALE = 3;
    const STATUS_CONSIDERATION = 4;
}
