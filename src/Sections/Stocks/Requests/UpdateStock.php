<?php

namespace NetLinker\WideStore\Sections\Stocks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStock extends FormRequest
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
            'stock' => 'required|integer',
            'availability' => 'required|integer',
            'department' => ['required', 'string', 'max:36', Rule::unique('wide_store_stocks')->where(function ($query) {
                return $query->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('department', $this->department)
                    ->where('type', $this->type)
->whereNull('deleted_at');
            })->ignore($this->id)],
            'type' => 'required|string|max:15',
        ];
    }
}


