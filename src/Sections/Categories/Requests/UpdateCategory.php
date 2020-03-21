<?php

namespace NetLinker\WideStore\Sections\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategory extends FormRequest
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
            'parent_uuid' => 'string|max:36',
            'identifier' => 'required|string|max:64',
            'deliverer' => 'required|string|max:24',
            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_categories')->where(function ($query) {
                return $query->where('identifier', $this->identifier)
                    ->where('deliverer', $this->deliverer)
                    ->where('lang', $this->lang)
                    ->where('type', $this->type)
                    ->whereNull('deleted_at');
            })->ignore($this->id)],
            'lang' => 'required|string|max:8',
            'type' => 'required|string|max:15',
        ];
    }
}


