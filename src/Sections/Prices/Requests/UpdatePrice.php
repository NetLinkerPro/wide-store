<?php

namespace NetLinker\WideStore\Sections\Prices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrice extends FormRequest
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
            'deliverer' => 'required|string|max:24',
            'currency' => ['required', 'string', 'max:15', Rule::unique('wide_store_prices')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('currency', $this->currency)
                    ->where('type', $this->type)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'type' => 'required|string|max:15',
            'price' => 'required|regex:/^\d+(\.\d{1,5})?$/',
        ];
    }
}


