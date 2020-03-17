<?php

namespace NetLinker\WideStore\Sections\IntegrationSchedulers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIntegrationScheduler extends FormRequest
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
            'cron' => ['required', 'string', 'max:255', Rule::unique('wide_store_integration_schedulers')->where(function ($query) {
                return $query->where('integration_uuid', $this->integration_uuid)
                    ->where('cron', $this->cron);
            })->ignore($this->id)],
        ];
    }
}


