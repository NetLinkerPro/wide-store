<?php

namespace NetLinker\WideStore\Sections\Prices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePrice extends FormRequest
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
            'deliverer' => 'required|string|max:255',
            'currency' => ['required', 'string', 'max:255', Rule::unique('wide_store_prices')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('currency', $this->currency)
                    ->where('type', $this->type)
                    ->whereNull('deleted_at');
            })],
            'type' => 'required|string|max:255',
            'price' => 'required|regex:/^\d+(\.\d{1,5})?$/',
        ];
    }
}


