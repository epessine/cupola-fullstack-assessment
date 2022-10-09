<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'state_id' => ['nullable', 'numeric', 'exists:states,id'],
            'city_id' => ['nullable', 'numeric', 'exists:cities,id'],
            'limit' => ['required', 'numeric', 'min:6'],
            'search' => ['nullable', 'string', 'max:255'],
        ];
    }
}
