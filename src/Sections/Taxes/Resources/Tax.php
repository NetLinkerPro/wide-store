<?php

namespace NetLinker\WideStore\Sections\Taxes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class Tax extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $product = Product::collection((new ProductRepository())->findWhere(['uuid' => $this->product_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'product_uuid' => $this->product_uuid,
            'product' => $product,
            'country' => $this->country,
            'tax' => $this->tax,
        ];
    }
}

