<?php

namespace NetLinker\WideStore\Sections\ShopImages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetLinker\WideStore\Ownerable;

class StoreShopImage extends FormRequest
{

    use Ownerable;

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
            'identifier' => ['required', 'string', 'max:255', Rule::unique('wide_store_shop_images')->where(function ($query) {
                return $query->where('shop_uuid', $this->shop_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('identifier', $this->department)
                    ->where('owner_uuid', $this->getAuthOwnerUuid())
                    ->whereNull('deleted_at');
            })],
            'url_target' => 'string|max:255',
            'order' => 'integer',
            'main' => 'boolean',
        ];
    }
}


