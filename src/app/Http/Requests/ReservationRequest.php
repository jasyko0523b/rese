<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'shop_id' => 'exists:shops,id|required|integer',
            'user_id' => 'exists:users,id|required|integer',
            'date' => 'required|date',
            'time' => 'required|string',
            'date_time' => 'date|after:now',
            'number' => 'required|integer|min:1|max:9',
        ];
    }

    public function prepareForValidation(){
        $date_time = ($this->filled(['date', 'time'])) ? $this->date . ' '. $this->time : '';
        $this->merge([
            'date_time' => $date_time,
        ]);
    }
}
