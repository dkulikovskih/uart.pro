<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'instrument' => ['required_if:role,musician', 'string', 'max:255'],
            'about' => ['required_if:role,musician', 'string', 'max:1000'],
            'experience' => ['required_if:role,musician', 'string', 'max:1000'],
            'skills' => ['required_if:role,musician', 'string', 'max:1000'],
            'education' => ['required_if:role,musician', 'string', 'max:1000'],
        ];
    }
}
