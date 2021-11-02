<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;


class CategoryFormRequest extends FormRequest
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
            'status' => 'numeric',
        ];
       if($this->id){
        $rule['name']=[
            'required',
            Rule::unique('categories')->ignore($this->id)
        ];
       }else{
        $rule['name']=[
            'required',
            Rule::unique('categories')
        ];
       }


        return $rule;
    }
    public function messages()
    {
        return [
          
            'name.required'=>'Hãy nhập tên danh mục',
            'name.unique'=>'Tên danh mục đã tồn tại xin mời nhập tên khác.',
           'status.numeric'=>'Hãy chọn trạng thái'
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
