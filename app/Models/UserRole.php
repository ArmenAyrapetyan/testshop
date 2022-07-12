<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRole extends Model
{
    use HasFactory, Notifiable;

    const USER_ADMIN = 1;
    const USER_CLIENT = 2;
    const USER_BANED = 3;
}
