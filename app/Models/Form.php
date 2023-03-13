<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "enabled",
        "destination",
        "style",
        "form_number" .
        "owner",
        "hash",
        "visits"
    ];

    public function getHash(): string
    {
        return $this->hash;
    }

    public function owner()
    {
        return $this->belongsTo(Client::class, 'owner');
    }
}
