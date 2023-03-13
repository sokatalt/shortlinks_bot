<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        "client_id", "first_name", "last_name", "username", "language", "subscription_tries", "subscription_id"
    ];

    public function is_subscribed()
    {
        $client = static::select("subscription_id")->first();
        return $client->subscription_id;
    }
    public function subscription(){
        return $this->hasOne(subscription::class,"id","subscription_id");
    }
    public function addSubscriptionTry(): void
    {
        $this->update([
            "subscription_tries" => $this->subscription_tries + 1
        ]);
    }

    public function resetSubscriptionTry(): void
    {
        $this->update([
            "subscription_tries" => 0
        ]);
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'owner', 'owner');
    }
}
