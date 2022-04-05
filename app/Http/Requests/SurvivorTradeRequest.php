<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class SurvivorTradeRequest extends FormRequest
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
            'survivor_id_1' => ['required'],
            'survivor1_item' => ['required', 'array'],
            'survivor1_item[*][item_id]' => ['required'],
            'survivor1_item[*][amount]' => ['required'],
            'survivor_id_2' => ['required'],
            'survivor2_item' => ['required', 'array'],
            'survivor2_item[*][item_id]' => ['required'],
            'survivor2_item[*][amount]' => ['required']
        ];
    }
}
