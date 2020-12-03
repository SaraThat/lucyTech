<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiFormRequest extends FormRequest
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
            'stake_amount' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'stake_amount.required' => "required"
        ];
    }

}
