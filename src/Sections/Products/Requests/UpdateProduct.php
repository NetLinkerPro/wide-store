<?php

namespace NetLinker\WideStore\Sections\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProduct extends FormRequest
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
            'deliverer' => 'required|string|max:24',
            'identifier' => ['required', 'string', 'max:38', Rule::unique('wide_store_products')->where(function ($query) {
                return $query->where('deliverer', $this->deliverer)
                    ->where('identifier', $this->identifier)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'name' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ];
    }
}


