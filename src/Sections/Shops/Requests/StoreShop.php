<?php

namespace NetLinker\WideStore\Sections\Shops\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetLinker\WideStore\Ownerable;

class StoreShop extends FormRequest
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
            'deliverer' => 'required|string|max:255',
            'formatter_uuid'=> 'required|string|max:36',
            'name' => ['required', 'string', 'max:255', Rule::unique('wide_store_shops')->where(function ($query) {
                return $query->where('name', $this->name)
                    ->where('owner_uuid', $this->getAuthOwnerUuid())
                    ->whereNull('deleted_at');
            })],
            'description' => 'nullable|string',
        ];
    }
}


