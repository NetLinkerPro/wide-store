<?php

namespace NetLinker\WideStore\Sections\ShopCategories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopCategory extends FormRequest
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
            'parent_uuid' => 'string|max:36',
            'shop_uuid' => 'required|string|max:36',
            'deliverer' => 'required|string|max:255',

            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_shop_categories')->where(function ($query) {
                return $query->where('parent_uuid', $this->parent_uuid)
                    ->where('shop_uuid', $this->shop_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('name', $this->name);
            })],
        ];
    }
}


