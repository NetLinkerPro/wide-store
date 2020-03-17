<?php

namespace NetLinker\WideStore\Sections\Integrations\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIntegration extends FormRequest
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
            'deliverer_configuration_uuid' => 'required|string|max:36',
            'deliverer' => ['required', 'string', 'max:255', Rule::unique('wide_store_integrations')->where(function ($query) {
                return $query->where('deliverer_configuration_uuid', $this->deliverer_configuration_uuid);
            })],
        ];
    }
}


