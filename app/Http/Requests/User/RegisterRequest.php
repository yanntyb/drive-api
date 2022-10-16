<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property string $email
 * @property string $name
 * @property string $password
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Merci de rentrer un email',
            'email.email' => 'Merci de rentrer un email valide',
            'email.unique' => "L'email rentré est déjà pris",
            'password.required' => 'Merci de rentrer un mot de passe',
            'password.confirmed' => 'Les deux mots de passe ne sont pas identiques',
            'name.required' => 'Merci de rentrer un nom',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
