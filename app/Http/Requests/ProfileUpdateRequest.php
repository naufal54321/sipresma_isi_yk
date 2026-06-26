<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            \Illuminate\Validation\Rule::unique('users')
                ->ignore($this->user()->id),
        ],
        'nim' => ['required', 'string', 'max:30'],
    ];

    // Mahasiswa wajib mengisi prodi
    if ($this->user()->hasRole('Mahasiswa')) {
        $rules['prodi'] = ['required', 'string', 'max:255'];
    } else {
        // Admin & Dosen boleh kosong
        $rules['prodi'] = ['nullable', 'string', 'max:255'];
    }

    return $rules;
}
}
