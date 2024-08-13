<?php

namespace App\Http\Requests\Cards;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
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
            'id_user' => 'required|integer|exists:users,id_user',
            'color' => 'required|string|max:10',
            'content' => 'nullable|string',
            'title' => 'nullable|string',
            'favorite' => 'required|boolean',
        ];
    }
}
