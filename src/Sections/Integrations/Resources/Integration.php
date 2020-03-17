<?php

namespace NetLinker\WideStore\Sections\Integrations\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Integration extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'deliverer_configuration_uuid' => $this->deliverer_configuration_uuid,
            'deliverer' => $this->deliverer,
        ];
    }
}

