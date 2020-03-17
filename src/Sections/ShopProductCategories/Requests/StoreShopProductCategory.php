<?php

namespace NetLinker\WideStore\Sections\ShopProductCategories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopProductCategory extends FormRequest
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
            'shop_uuid' => 'required|string|max:36',
            'product_uuid' => 'required|string|max:36',
            'category_uuid' => 'required|string|max:36',
            'deliverer' => ['required', 'string', 'max:255', Rule::unique('wide_store_shop_product_categories')->where(function ($query) {
                return $query->where('shop_uuid', $this->parent_uuid)
                    ->where('product_uuid', $this->shop_uuid)
                    ->where('category_uuid', $this->deliverer)
                    ->where('deliverer', $this->name);
            })],
        ];
    }
}


