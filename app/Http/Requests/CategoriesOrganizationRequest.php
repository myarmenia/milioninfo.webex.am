<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoriesOrganizationRequest extends FormRequest
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
          "latitude"=>"required",
          "longitude" => "required"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // Here is your array of errors

        throw new HttpResponseException(response()->json(['errors'=>$errors],422));

    }
}
