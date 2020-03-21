<?php

namespace NetLinker\WideStore\Sections\Images\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateImage extends FormRequest
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
            'identifier' => ['required', 'string', 'max:50', Rule::unique('wide_store_identifiers')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('identifier', $this->identifier)
                    ->where('lang', $this->lang)
                    ->where('type', $this->type)
->whereNull('deleted_at');
            })->ignore($this->id)],

            'url_source' => 'string|max:255',
            'path' => 'string|max:255',
            'disk' => 'string|max:255',
            'url_target' => 'string|max:255',
            'order' => 'integer',
            'main' => 'boolean',
            'active' => 'boolean',
            'lang' => 'required|string|max:8',
            'type' => 'required|string|max:15',

        ];
    }
}


