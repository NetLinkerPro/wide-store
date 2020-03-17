<?php

namespace NetLinker\WideStore\Sections\Settings\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Integrations\Repositories\IntegrationRepository;
use NetLinker\WideStore\Sections\Integrations\Resources\Integration;

class Setting extends JsonResource
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
            'deliverer' => $this->deliverer,
            'name' => $this->name,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}

