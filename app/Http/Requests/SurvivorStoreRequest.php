<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest as FormRequest;

class SurvivorStoreRequest extends FormRequest
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
            'name' => ['required'],
            'age' => ['required'],
            'gender' => ['required'],
            'initial_item' => ['nullable', 'array'],
            'initial_item[*][item_id]' => ['nullable'],
            'initial_item[*][amount]' => ['nullable']
        ];
    }
}
