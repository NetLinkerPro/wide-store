<?php

namespace NetLinker\WideStore\Sections\MyPrices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetLinker\WideStore\Ownerable;

class StoreMyPrice extends FormRequest
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
            'configuration_uuid' => 'required|string|max:36',
            'product_uuid' => 'required|string|max:36',
            'deliverer' => 'required|string|max:24',
            'currency' => ['required', 'string', 'max:15', Rule::unique('wide_store_my_prices')->where(function ($query) {
                return $query->where('configuration_uuid', $this->configuration_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('currency', $this->currency)
                    ->where('owner_uuid', $this->getAuthOwnerUuid())
                    ->where('type', $this->type)
                    ->whereNull('deleted_at');
            })],
            'type' => 'required|string|max:15',
            'price' => 'required|regex:/^\d+(\.\d{1,5})?$/',
        ];
    }
}


