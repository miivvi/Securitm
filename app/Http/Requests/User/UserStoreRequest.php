<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * RequestBody
 * mediaType="application/json",
 * Properties (
 *      property="name", type="string", example="Name"
 *      property="email", type="string", example="test@test.com"
 *      property="ip", type="string", example="127.0.0.0"
 *      property="comment", type="string", example="text text text"
 *      property="password", type="string", example="Test123!"
 * )
 */
final class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'ip' => 'required|string|ip',
            'comment' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
}
