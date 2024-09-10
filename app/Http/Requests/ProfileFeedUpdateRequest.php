<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFeedUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feed' => 'nullable'
        ];
    }
}
