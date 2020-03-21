<?php

namespace NetLinker\WideStore\Sections\Identifiers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIdentifier extends FormRequest
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
            'identifier' => ['required', 'string', 'max:38', Rule::unique('wide_store_identifiers')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('identifier', $this->identifier)
                    ->where('type', $this->type)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'type' => 'required|string|max:15',
        ];
    }
}


