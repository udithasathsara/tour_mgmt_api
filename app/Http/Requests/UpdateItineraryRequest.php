<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateItineraryRequest extends FormRequest
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
            //
            'title' => 'sometimes|string|max:255',
            'notes' => 'nullable|string',
            'days' => 'sometimes|array|min:1',
            'days.*.day' => [
                'required_with:days',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $days = collect($this->days)->pluck('day');
                    if ($days->unique()->count() !== $days->count()) {
                        $fail('Days must be unique.');
                    }
                    if ($days->sort()->values()->toArray() !== $days->values()->toArray()) {
                        $fail('Days must be sequential.');
                    }
                }
            ],
            'days.*.location' => 'required_with:days|string|max:255',
            'days.*.activities' => 'required_with:days|array|min:1',
            'days.*.activities.*' => 'string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'days.*.day.required_with' => 'Each day must have a day number',
            'days.*.location.required_with' => 'Each day must have a location',
            'days.*.activities.required_with' => 'Each day must have activities'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}
