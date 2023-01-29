<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'slug'=>'required|min:3|max:50|unique:categories,slug',
            'name'=>'required|min:3|max:50',
            'description'=>'required|min:5',
        ];
        if ($this->route()->named('categories.update')) {
            $rules['slug'] .= ',' . $this->route()->parameter('category')->id;
        }
//        dd(get_class_methods($this->route()));
        return $rules;
    }

    public function messages()
    {
        return[
            'required' => 'Поле :attribute обязтельно для заполнения',
            'slug.min' => 'Поле КОД должно содержать минимум :min символов',
            'slug.max' => 'Поле КОД должно содержать минимум :max символов',
            'name.min' => 'Поле НАЗВАНИЕ должно содержать минимум :min символов',
            'name.max' => 'Поле НАЗВАНИЕ должно содержать минимум :max символов',
            'description.min' => 'Поле ОПИСАНИЕ должно содержать минимум :min символов'
        ];
    }
}
