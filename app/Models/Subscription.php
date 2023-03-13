<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        "key", "used", "expire_at"
    ];

    public static function isValidKey(string $key): bool
    {
        // CHeck if the key exist in the database
        $subscription = Subscription::firstWhere('key', $key);

        if ($subscription) {

            // TODO: improve code
            // Check if it's in use
            if (self::inUse($subscription)) {
                return false;
            }

            // Check if it's already used
            if ($subscription->used) {
                return false;
            }

            return true;

        }
        return false;

    }

    public static function inUse(Subscription $subscription): bool
    {
        // find if there is a client using it
        $client = Client::firstWhere("subscription_id", $subscription->id);

        // return true if none
        return $client !== null;
    }

    // make the subscription key USED
    public static function usedKey(string $key)
    {
        // find the key and make it used
        self::where('key', $key)->update(['used' => 1]);
    }
}
