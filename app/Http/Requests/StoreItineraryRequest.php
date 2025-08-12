<?php

namespace App\Http\Requests;

use App\Models\Enquiry;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class StoreItineraryRequest extends FormRequest
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
            'enquiry_id' => [
                'required',
                'exists:enquiries,id',
                function ($attribute, $value, $fail) {
                    $enquiry = Enquiry::find($value);

                    if (!$enquiry->assigned_agent_id) {
                        $fail('No agent assigned to this enquiry.');
                    }

                    if ($enquiry->assigned_agent_id !== $this->user()->id) {
                        $fail('You are not the assigned agent for this enquiry.');
                    }
                }
            ],
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'days' => 'required|array|min:1',
            'days.*.day' => [
                'required',
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
            'days.*.location' => 'required|string|max:255',
            'days.*.activities' => 'required|array|min:1',
            'days.*.activities.*' => 'string|max:255'
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
