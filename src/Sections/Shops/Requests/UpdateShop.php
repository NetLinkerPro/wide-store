<?php

namespace NetLinker\WideStore\Sections\Shops\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShop extends FormRequest
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
            'format_uuid' => ['required', 'string', 'max:48', Rule::unique('wide_store_shops')->where(function ($query) {
                return $query->where('format_uuid', $this->format_uuid)
                    ->where('integration_uuid', $this->integration_uuid)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'integration_uuid' => 'required|string|max:36',
            'name' => 'string|max:255',
            'description' => 'nullable|string',
        ];
    }
}


