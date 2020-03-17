<?php

namespace NetLinker\WideStore\Sections\Shops\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Formats\Repositories\FormatRepository;
use NetLinker\WideStore\Sections\Formats\Resources\Format;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Integrations\Repositories\IntegrationRepository;
use NetLinker\WideStore\Sections\Integrations\Resources\Integration;

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

        $integration = Integration::collection((new IntegrationRepository())->findWhere(['uuid' => $this->integration_uuid]))[0];
        $format = Format::collection((new FormatRepository())->findWhere(['uuid' => $this->format_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'integration_uuid' => $this->integration_uuid,
            'integration' => $integration,
            'format_uuid' => $this->format_uuid,
            'format' => $format,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

