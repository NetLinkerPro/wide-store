<?php

namespace NetLinker\WideStore\Sections\ShopAttributes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopAttribute extends FormRequest
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
            'deliverer' => 'required|string|max:255',
            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_shop_attributes')->where(function ($query) {
                return $query->where('shop_uuid', $this->shop_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('name', $this->name)
                    ->whereNull('deleted_at');
            })],
            'value' => 'string',
            'order' => 'integer',
        ];
    }
}


