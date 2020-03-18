<?php

namespace NetLinker\WideStore\Sections\MyPrices\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Configurations\Services\Deliverer;
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

        $deliverer = new Deliverer();

        $resource = $deliverer->getClassResource($this->deliverer);
        $repository = $deliverer->getRepository($this->deliverer);

        $configuration = $resource::collection($repository->findWhere(['uuid' => $this->configuration_uuid]))[0];
        $product = Product::collection((new ProductRepository())->findWhere(['uuid' => $this->product_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'configuration_uuid' => $this->configuration_uuid,
            'configuration' => $configuration,
            'product_uuid' => $this->product_uuid,
            'product' => $product,
            'deliverer' => $this->deliverer,
            'currency' => $this->currency,
            'type' => $this->type,
            'price' => $this->price,
        ];
    }
}

