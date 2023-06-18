<?php namespace App\Library\Requests\User;

use Velent\Abstracts\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }

    public function prepareRequest(){
        $request = $this;
        return [
            'email' => $request['email'],
            'password' => $request['password']
        ];
    }

}
