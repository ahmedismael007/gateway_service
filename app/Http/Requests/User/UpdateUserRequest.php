<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user_id = $this->route('user')?->id ?? $this->user()->id;

        return [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name'  => ['sometimes', 'string', 'max:255'],
            'username'   => ['sometimes', 'string', 'max:255', 'unique:users,username,'.$user_id],
            'email'      => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$user_id],
            'phone'      => ['sometimes', 'string', 'max:20', 'unique:users,phone,'.$user_id],
            'password'   => ['sometimes', 'string', 'min:8'],
            'status'     => ['in:active,inactive'],
            'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }
}
