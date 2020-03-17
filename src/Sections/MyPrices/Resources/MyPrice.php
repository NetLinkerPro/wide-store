<?php

namespace NetLinker\WideStore\Sections\MyPrices\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Integrations\Repositories\IntegrationRepository;
use NetLinker\WideStore\Sections\Integrations\Resources\Integration;

class MyPrice extends JsonResource
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
        $product = Product::collection((new ProductRepository())->findWhere(['uuid' => $this->product_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'integration_uuid' => $this->integration_uuid,
            'integration' => $integration,
            'product_uuid' => $this->product_uuid,
            'product' => $product,
            'deliverer' => $this->deliverer,
            'currency' => $this->currency,
            'type' => $this->type,
            'price' => $this->price,
        ];
    }
}

