<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class infoUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule=[
            'user_id'=>[
                'required',
                'exists:users,id'
            ],
            'phone'=>'required|numeric',
            'address'=>'required',
            'birthday'=>'required|date_format:Y-m-d',
            'gender'=>[
                'required',
                Rule::in([0,1,2])
            ],
            'image'=>'required|max:255',
        ];
        return $rule;
    }
    public  function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'success' => 'Invalid data send',
            'data' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
