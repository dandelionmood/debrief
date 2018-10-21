<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUniverse extends FormRequest
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
            'label'       => 'nullable',
            'description' => 'nullable',
            'user_id'     => 'numeric|exists:users',
            'picture'     => ['nullable', 'file', 'image', 'dimensions:ratio=1/1'],
        ];
    }
}
