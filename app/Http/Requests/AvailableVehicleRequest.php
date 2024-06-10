<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'nullable|string',
            'model' => 'nullable|string',
            'date_start' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'date_start.required' => 'Дата запланированной поездки обязательна',
        ];
    }
}
