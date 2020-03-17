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
            'deliverer' => 'required|string|max:255',
            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_categories')->where(function ($query) {
                return $query->where('parent_uuid', $this->parent_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('name', $this->name)
                    ->where('lang', $this->lang)
                    ->where('type', $this->type);
            })->ignore($this->id)],
            'lang' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ];
    }
}


