<?php

namespace NetLinker\WideStore\Sections\Stocks\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class Stock extends JsonResource
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
            'deliverer' => $this->deliverer,
            'product' => $product,
            'stock' => $this->stock,
            'availability' => $this->availability,
            'department' => $this->department,
            'type' => $this->type,
        ];
    }
}

