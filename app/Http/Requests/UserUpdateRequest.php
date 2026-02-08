<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('user'); // or 'user' depending on your route parameter
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id->id,
            'branchID' => 'required',
            'password' => 'required|min:8',
        ];
    }
}
