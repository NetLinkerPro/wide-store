<?php

namespace NetLinker\WideStore\Sections\IntegrationSchedulers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Integrations\Repositories\IntegrationRepository;
use NetLinker\WideStore\Sections\Integrations\Resources\Integration;

class IntegrationScheduler extends JsonResource
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

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'integration_uuid' => $this->integration_uuid,
            'integration' => $integration,
            'cron' => $this->cron,
        ];
    }
}

