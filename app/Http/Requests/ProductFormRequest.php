<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
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
        $cates=Category::all();
        $arr_cate_id=[];
        foreach($cates as $c){
            $arr_cate_id[]=$c->id;
        }
        $rule=[
            'cate_id' => [
                'required',
                Rule::in($arr_cate_id)
            ],
           
            'image' => 'required|string',
            'price' => 'required|numeric|min:5',
            'sale' => 'numeric|between:0,100',
            'quantity' => 'numeric',
            'desc_short' => 'required',
            'description' => 'required'
        ];
       if($this->id){
        $rule['name']=[
            'required',
            Rule::unique('products')->ignore($this->id)
        ];
       }else{
        $rule['name']=[
            'required',
            Rule::unique('products')
        ];
       }


        return $rule;
    }
    public function messages()
    {
        return [
            'cate_id.required'=>'Hãy nhập tên danh mục*.',
            'name.required'=>'Hãy nhập tên sản phẩm',
            'name.unique'=>'Tên sản phẩm đã tồn tại xin mời nhập tên khác.',
            'image.required'=>'Hãy nhập link ảnh sản phẩm',
            'image.string'=>'Link ảnh sản phẩm không phải là chuỗi',
            'price.required'=>'Hãy nhập giá sản phẩm',
            'price.numeric'=>'Giá sản phẩm không được chứa kí tự',
            'sale.numeric'=>'Mã giảm không phẩm không được chứa kí tự',
            'sale.between'=>'Mã giảm giá không quá 100%',
            'quantity.numeric'=>'Số lượng sản phẩm không chứa kí tự',
            'desc_short.required'=>'Hãy nhập mổ tả ngắn.',
            'description.required'=>'Hãy nhập mô tả chi tiết'
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
