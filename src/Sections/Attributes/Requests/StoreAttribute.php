<?php

namespace NetLinker\WideStore\Sections\Attributes\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttribute extends FormRequest
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
            'name' => ['required', 'string', 'max:50', Rule::unique('wide_store_attributes')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('name', $this->name)
                    ->where('lang', $this->lang)
                    ->where('type', $this->type)
                    ->whereNull('deleted_at');
            })],

            'value' => 'required|string',
            'order' => 'integer',
            'lang' => 'required|string|max:8',
            'type' => 'required|string|max:15',
        ];
    }
}


