<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead2 extends Model
{
    use HasFactory;
    protected $table='lead2s';
    protected $fillable =[
            'name',
            'address',
            'phone',
            'email',
            'compain_user_id',
            'ip'
    ];
}
