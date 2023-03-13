<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShortUrl extends Model
{
    use HasFactory;
    protected $table ='users_shorturls';

    protected   $fillable=[
        'id',
        'user_id',
        'short_url_id',
        'user_compain_id'
    ];
}
