<?php

namespace NetLinker\WideStore\Sections\Settings\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSetting extends FormRequest
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
            'deliverer' => ['required', 'string', 'max:255', Rule::unique('wide_store_settings')->where(function ($query) {
                return $query->where('deliverer', $this->deliverer)
                    ->where('key', $this->key);
            })->ignore($this->id)],
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'nullable|string',
        ];
    }
}


