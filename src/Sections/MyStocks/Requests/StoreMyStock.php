<?php

namespace NetLinker\WideStore\Sections\MyStocks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetLinker\WideStore\Ownerable;

class StoreMyStock extends FormRequest
{

    use Ownerable;
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
            'configuration_uuid' => 'required|string|max:36',
            'product_uuid' => 'required|string|max:36',
            'deliverer' => 'required|string|max:24',
            'stock' => 'required|integer',
            'availability' => 'required|integer',
            'department' => ['required', 'string', 'max:36', Rule::unique('wide_store_my_stocks')->where(function ($query) {
                return $query->where('configuration_uuid', $this->configuration_uuid)
                    ->where('product_uuid', $this->product_uuid)
                    ->where('deliverer', $this->deliverer)
                    ->where('department', $this->department)
                    ->where('type', $this->type)
                    ->where('owner_uuid', $this->getAuthOwnerUuid())
                    ->whereNull('deleted_at');
            })],
            'type' => 'required|string|max:15',
        ];
    }
}


