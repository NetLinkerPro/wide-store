<?php

namespace NetLinker\WideStore\Sections\Shops\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use NetLinker\WideStore\Sections\Formatters\Services\Deliverer as DelivererFormatter;
use NetLinker\WideStore\Sections\Configurations\Services\Deliverer as DelivererConfiguration;

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

        $formatter = null;
        $configuration = null;

        if (!Str::startsWith($this->deliverer, 'custom')){

            $delivererFormatter = new DelivererFormatter();
            $delivererConfiguration = new DelivererConfiguration();

            $resource = $delivererFormatter->getClassResource($this->deliverer);
            $repository = $delivererFormatter->getRepository($this->deliverer);
            $formatter = $resource::collection($repository->findWhere(['uuid' => $this->formatter_uuid]))[0] ?? null;

            $resource = $delivererConfiguration->getClassResource($this->deliverer);
            $repository = $delivererConfiguration->getRepository($this->deliverer);
            $configuration = $resource::collection($repository->findWhere(['uuid' => $this->configuration_uuid]))[0] ?? null;
        }

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'deliverer' => $this->deliverer,
            'formatter_uuid' => $this->formatter_uuid,
            'formatter' => $formatter,
            'configuration_uuid' => $this->configuration_uuid,
            'configuration' => $configuration,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

