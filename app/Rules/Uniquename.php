<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Game;

class Uniquename implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $preexistingGameWithCurrentName = Game::where('user_id', auth()->user()->id)->where('name', $value)->first();
        return is_null($preexistingGameWithCurrentName);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have already posted a game named :input.';
    }
}
