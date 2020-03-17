<?php

namespace NetLinker\WideStore\Sections\Names\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateName extends FormRequest
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
            'deliverer' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'lang' => ['required', 'string', 'max:255', Rule::unique('wide_store_names')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('lang', $this->lang)
                    ->where('type', $this->type);
            })->ignore($this->id)],
            'type' => 'required|string|max:255',
        ];
    }
}


