<?php

namespace NetLinker\WideStore\Sections\ShopAttributes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetLinker\WideStore\Ownerable;

class UpdateShopAttribute extends FormRequest
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
            'deliverer' => 'required|string|max:24',
            'name' => ['required', 'string', 'max:50', Rule::unique('wide_store_shop_attributes')->where(function ($query) {
                return $query->where('shop_uuid', $this->shop_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('owner_uuid', $this->getAuthOwnerUuid())
                    ->where('name', $this->name)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'value' => 'string',
            'order' => 'integer',
        ];
    }
}


