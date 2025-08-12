<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreEnquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::info('Test log entry for Telescope');
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

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'travel_start_date' => 'required|date|after_or_equal:today',
            'travel_end_date' => 'required|date|after_or_equal:travel_start_date',
            'number_of_people' => 'required|integer|min:1',
            'preferred_destinations' => 'required|array|min:1',
            'preferred_destinations.*' => 'string|max:255',
            'budget' => 'required|numeric|min:0.01'
        ];
    }

    public function messages()
    {

        return [
            'travel_start_date.after_or_equal' => 'Start date must be in the future',
            'travel_end_date.after_or_equal' => 'End date must be after start date'

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
