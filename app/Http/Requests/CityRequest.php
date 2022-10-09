<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'state_id' => ['nullable', 'numeric', 'exists:states,id'],
        ];
    }
}
