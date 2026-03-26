<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'alpha_dash', 'min:3', 'max:63'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'theme_id' => ['nullable', 'exists:themes,id'],
        ];
    }
}
