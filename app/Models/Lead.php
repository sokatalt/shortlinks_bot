<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $table='leads';
    protected $fillable =[
            'name',
            'address',
            'phone',
            'email',
            'compain_user_id',
            'ip'
    ];
}