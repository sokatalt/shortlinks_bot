<?php

namespace App\helpers;

use WeStacks\TeleBot\Handlers\UpdateHandler;
use WeStacks\TeleBot\TeleBot;

/**
 * Abstract class for creating Telegram update handlers.
 */
abstract class RequestInputHandler extends UpdateHandler
{
    protected static function getState(TeleBot $bot)
    {
        $statePath = storage_path()."/" . $bot->config('name') . ".json";
        return file_exists($statePath) ? json_decode(file_get_contents($statePath), true) : [];
    }

    protected static function updateState(TeleBot $bot, callable $callback)
    {
        $statePath = storage_path()."/" . $bot->config('name') . ".json";
        $state = static::getState($bot);

        $state = $callback($state);

        return !!file_put_contents($statePath, json_encode($state));
    }

    public static function requestInput(TeleBot $bot, string $user_id)
    {
        return static::updateState($bot, function ($state) use ($user_id) {
            $state[$user_id] = static::class;
            return $state;
        });
    }

    public function trigger()
    {
        return  ($this->update->message()->text ?? false) &&
                static::class == (static::getState($this->bot)[$this->update->user()->id] ?? null);
    }

    protected function acceptInput()
    {
        return static::updateState($this->bot, function ($state) {
            unset($state[$this->update->user()->id]);
            return $state;
        });
    }

    public function __invoke($next)
    {
        return $this->trigger() ? $this->handle() : $next();
    }
}
