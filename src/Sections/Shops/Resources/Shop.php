<?php

namespace NetLinker\WideStore\Sections\Shops\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use NetLinker\WideStore\Sections\Formatters\Services\Deliverer;

class Shop extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $deliverer = new Deliverer();

        $formatter = null;

        if (!Str::startsWith($this->deliverer, 'custom')){
            $resource = $deliverer->getClassResource($this->deliverer);
            $repository = $deliverer->getRepository($this->deliverer);

            $formatter = $resource::collection($repository->findWhere(['uuid' => $this->formatter_uuid]))[0];
        }

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'deliverer' => $this->deliverer,
            'formatter_uuid' => $this->formatter_uuid,
            'formatter' => $formatter,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

