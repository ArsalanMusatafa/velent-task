<?php namespace Velent\Requests\User;

use Illuminate\Support\Facades\Hash;
use Velent\Abstracts\FormRequest;
use Velent\Helper\Helper;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8|max:16',
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000'
        ];
    }

    public function prepareRequest(){
        $request = $this;
        $data = [
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ];

        if (isset($request['photo']) && $request['photo']){
            $data['photo'] = Helper::uploadImage('profiles', $request['photo']);
        }

        return $data;
    }
}
