<?php

namespace NetLinker\WideStore\Sections\ProductCategories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductCategory extends FormRequest
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
            'product_uuid' => 'required|string|max:36',
            'category_uuid' => 'required|string|max:36',
            'deliverer' => ['required', 'string', 'max:24', Rule::unique('wide_store_product_categories')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('category_uuid', $this->category_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('type', $this->type)
                    ->whereNull('deleted_at');
            })],
            'type' => 'required|string|max:255',
        ];
    }
}


