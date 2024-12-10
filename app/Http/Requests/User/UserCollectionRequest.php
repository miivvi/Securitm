<?php

namespace App\Http\Requests\User;

use App\Services\Request\Validation\HasSort;
use Illuminate\Foundation\Http\FormRequest;

final class UserCollectionRequest extends FormRequest
{
    use HasSort;

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
        ] + $this->sortRule('name');
    }
}
