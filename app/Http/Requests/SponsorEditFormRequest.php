<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SponsorEditFormRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'description'=>['nullable','string'],
            'logo' => ['nullable','image','mimes:png,jpg,jpeg,gif','max:2048'],
            'sponsored' => ['required','numeric','min:0'],
            'url'=> ['nullable','string']
        ];
    }
}