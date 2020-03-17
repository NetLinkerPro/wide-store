<?php

namespace NetLinker\WideStore\Sections\MyStocks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMyStock extends FormRequest
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
            'integration_uuid' => 'required|string|max:36',
            'product_uuid' => 'required|string|max:36',
            'deliverer' => 'required|string|max:255',
            'stock' => 'required|integer',
            'availability' => 'required|integer',
            'department' => ['required', 'string', 'max:128', Rule::unique('wide_store_my_stocks')->where(function ($query) {
                return $query->where('integration_uuid', $this->integration_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('department', $this->department)
                    ->where('type', $this->type);
            })->ignore($this->id)],
            'type' => 'required|string|max:255',
        ];
    }
}


