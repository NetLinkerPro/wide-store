<?php

namespace NetLinker\WideStore\Sections\Taxes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTax extends FormRequest
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
            'country' => ['required', 'string', 'max:48', Rule::unique('wide_store_taxes')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('country', $this->country)
                    ->where('tax', $this->tax)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'tax' => 'required|integer',
        ];
    }
}


