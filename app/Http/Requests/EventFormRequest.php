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
        'title' => ['required', 'string', 'max:100', 'not_regex:/[\'"*]/'],
        'date' => ['required', 'date', 'after_or_equal:today'],
        'description' => ['string', 'nullable', 'not_regex:/[\'"*]/'],
        'start_time' => ['required', 'string', 'before:end_time'],
        'end_time' => ['required', 'string', 'after:start_time'],
        'location' => ['required', 'string', 'not_regex:/[\'"*]/'],
        'poster' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif', 'max:2048']
    ];
}

public function messages()
{
    return [
        'date.after_or_equal' => 'De datum mag niet vroeger dan vandaag zijn.',
        'title.not_regex' => '*," en \' characters zijn niet toegestaan.',
        'description.not_regex' => '*," en \' characters zijn niet toegestaan.',
        'location.not_regex' => '*," en \' characters zijn niet toegestaan.',
        'start_time.after' => 'De starttijd moet in de toekomst zijn.',
        'start_time.before' => 'De starttijd moet vóór de eindtijd zijn.',
        'end_time.after' => 'De eindtijd moet na de starttijd zijn.',
    ];
}

}
