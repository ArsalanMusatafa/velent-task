<?php namespace Velent\Requests\User;

use Illuminate\Support\Facades\Hash;
use Velent\Abstracts\FormRequest;
use Velent\Helper\Helper;

class UserUpdateRequest extends FormRequest
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
            'photo' => 'nullable|mimes:jpeg,jpg,png|max:10000',
            'id' => 'exists:users,id',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('user');
        return $data;
    }

    public function prepareRequest(){
        $request = $this;
        $data = [
            'firstName' => $request['firstName'],
            'lastName' => $request['lastName'],
        ];

        if (isset($request['photo']) && $request['photo']){
            $data['photo'] = Helper::uploadImage('profiles', $request['photo']);
        }
        return $data;
    }
}
