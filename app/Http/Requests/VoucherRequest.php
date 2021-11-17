<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class VoucherRequest extends FormRequest
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
            'classify_voucher_id'=> 'required',
            'title'=> 'required',
            'code'=> 'required',
            'sale'=> 'required',
            'customer_type'=> 'required',
            'condition'=> 'required',
            'expiration'=> 'required',
            'active'=> 'required',
            'planning'=> 'required',
            'times'=> 'required',
            'start_day'=> 'required',
            'end_day'=> 'required',
        ];
    }
      public function messages()
    {
        return [
           'classify_voucher_id',
            'title',
            'code',
            'sale',
            'customer_type',
            'condition',
            'expiration',
            'active',
            'planning',
            'times',
            'start_day',
            'end_day',
            'condition',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
