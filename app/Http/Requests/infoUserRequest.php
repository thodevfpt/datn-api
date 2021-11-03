<?php

namespace App\Http\Requests;
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
        return [
            'user_id'=>'required',
            'pro_id'=>'required',
            'phone'=>'required',
            'address'=>'required|min:5',
            'birthday'=>'required|date',
            'gender'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'user_id',
            'pro_id',
            'phone',
            'address',
            'birthday',
            'birthday',
            'gender',

        ];
    }
    public  function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
