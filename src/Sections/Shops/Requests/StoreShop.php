<?php

namespace NetLinker\WideStore\Sections\Shops\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShop extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_shops')->where(function ($query) {
                return $query->where('name', $this->name)
                    ->whereNull('deleted_at');
            })],
            'description' => 'nullable|string',
        ];
    }
}


