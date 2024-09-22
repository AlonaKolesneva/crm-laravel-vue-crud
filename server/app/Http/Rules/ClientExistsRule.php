<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Client;

class ClientExistsRule implements Rule
{
    public function passes($attribute, $value)
    {
        return Client::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected client does not exist.';
    }
}