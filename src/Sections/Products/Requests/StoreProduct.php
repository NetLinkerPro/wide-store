<?php

namespace NetLinker\WideStore\Sections\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProduct extends FormRequest
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
            'category_uuid' => 'required|string|max:36',
            'deliverer' => 'required|string|max:255',
            'identifier' => ['required', 'string', 'max:255', Rule::unique('wide_store_products')->where(function ($query) {
                return $query->where('deliverer', $this->deliverer)
                    ->where('identifier', $this->identifier)
                    ->whereNull('deleted_at');
            })],
            'name' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ];
    }
}


