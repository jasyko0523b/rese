<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopImageRequest extends FormRequest
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
            'image_file' => ['required', 'array'],
            'image_file.*' => ['required', 'file', 'mimetypes:image/jpeg,image/png', 'mimes:jpeg,jpg,png'],
        ];
    }


    public function messages()
    {
        $messages = [];
        if($this->image_file){
            foreach ($this->image_file as $key => $value) {
                $messages["image_file.{$key}.*"] = "jpeg、pngファイルのみアップロード可能です";
            }
        }
        return $messages;
    }
}
