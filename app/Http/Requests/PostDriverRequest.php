<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostDriverRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'no_whatsapp' => 'required|numeric',
            'location' => 'required|string',
            'plat_number' => 'required|string',
            'vehicle_type' => 'required|string',
            'vehicle_name' => 'required|string',
            'ektp' => 'required|file|mimes:jpg,png,jpeg|max:2048',
            'sim' => 'required|file|mimes:jpg,png,jpeg|max:2048',
            // 'photo_profile' => 'required|file|mimes:jpg,png,jpeg,webp|max:2048',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}
