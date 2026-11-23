<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', "regex:/^[\pL\s.'-]+$/u"],
            'contact_number' => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'purpose' => ['required', 'string', 'max:255'],
            'person_to_visit' => ['nullable', 'required_without:department', 'string', 'max:100'],
            'department' => ['nullable', 'required_without:person_to_visit', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name may only contain letters, spaces, periods, apostrophes and hyphens.',
            'contact_number.regex' => 'Enter a valid contact number (7-20 digits; + - ( ) allowed).',
            'person_to_visit.required_without' => 'Enter the person or the department being visited.',
            'department.required_without' => 'Enter the department or the person being visited.',
        ];
    }
}
