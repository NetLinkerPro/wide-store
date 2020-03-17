<?php

namespace NetLinker\WideStore\Sections\ShopProducts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopProduct extends FormRequest
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
            'category_uuid' => 'string|max:36',
            'deliverer' => 'required|string|max:255',
            'identifier' => ['required', 'string', 'max:255', Rule::unique('wide_store_shop_products')->where(function ($query) {
                return $query->where('shop_uuid', $this->shop_uuid)
                    ->where('identifier', $this->identifier)
                    ->whereNull('deleted_at');
            })],
            'name' => 'required|string|max:255',
            'price' => 'required|regex:/^\d+(\.\d{1,5})?$/',
            'tax' => 'required|integer',
            'url' =>'string|max:255',
        ];
    }
}


