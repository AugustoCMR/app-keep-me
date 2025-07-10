<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class StoreIncomeRequest extends FormRequest
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
            'description'  => 'nullable|string|max:255',
            'amount'       => 'required|numeric|min:0.01',
            'account_id'   => 'required|exists:accounts,id',
            'category_id'  => 'required|exists:categories,id',
            'user_id'      => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'required'             => ':attribute is required.',
            'numeric'              => ':attribute is not a number.',
            'min'                  => ':attribute must be greater than :min.',
            'exists'               => ':attribute does not exist.'
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'description',
            'amount'      => 'amount',
            'account_id'  => 'account',
            'category_id' => 'category',
            'user_id'     => 'user',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        $friendlyErrors = collect($errors)->flatten()->values()->all();

        $failedRules = $validator->failed();

        $hasExistsError = collect($failedRules)->some(fn($failures) => isset($failures['Exists']));

        $status = $hasExistsError ? Response::HTTP_NOT_FOUND : Response::HTTP_UNPROCESSABLE_ENTITY;

        throw new HttpResponseException(response()->json([
            'errors' => $friendlyErrors,
        ], $status));
    }
}
