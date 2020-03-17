<?php

namespace NetLinker\WideStore\Sections\ShopDescriptions\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;
use NetLinker\WideStore\Sections\ShopProducts\Resources\ShopProduct;
use NetLinker\WideStore\Sections\Shops\Resources\Shop;

class ShopDescription extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = ShopProduct::collection((new ShopProductRepository())->findWhere(['uuid' => $this->product_uuid]))[0];
        $shop = Shop::collection((new ShopRepository())->findWhere(['uuid' => $this->shop_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'shop_uuid' => $this->shop_uuid,
            'shop' => $shop,
            'product_uuid' => $this->product_uuid,
            'product' => $product,
            'deliverer' => $this->deliverer,
            'description' => $this->description,
        ];
    }
}

