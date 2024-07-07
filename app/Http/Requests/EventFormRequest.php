<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
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
            'date' => ['required', 'date','after_or_equal:today'],
            'description'=>['string','nullable'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string'],
            'location' => ['required', 'string'],
            'poster'=>['nullable', 'image','mimes:png,jpg,jpeg,gif','max:2048']
        ];
    }
    public function messages()
    {
        return [
            'date.after_or_equal' => 'De datum mag niet vroeger dan vandaag zijn.',
        ];
    }
}
