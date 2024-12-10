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
final class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'ip' => 'sometimes|ip',
            'comment' => 'sometimes|nullable|string',
            'password' => 'sometimes|string|min:6|confirmed',
        ];
    }
}
