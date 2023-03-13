<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    use HasFactory;
    protected $table='short_urls';
    protected $fillable = [
        'destination_url',
        'default_short_url',
        'url_key',
        'single_use',
        'forward_query_params',
        'track_visits',
        'redirect_status_code',
        'track_ip_address',
        'track_operating_system',
        'track_operating_system_version',
        'track_browser',
        'track_browser_version',
        'track_referer_url',
        'track_device_type',
        'compain_id',
        'user_id',
        'activated_at',
        'deactivated_at',
    ];
}
