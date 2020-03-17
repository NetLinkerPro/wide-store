<?php

namespace NetLinker\WideStore\Sections\ShopProducts\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\ShopCategories\Repositories\ShopCategoryRepository;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;
use NetLinker\WideStore\Sections\ShopCategories\Resources\ShopCategory;
use NetLinker\WideStore\Sections\Shops\Resources\Shop;

class ShopProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = ShopCategory::collection((new ShopCategoryRepository())->findWhere(['uuid' => $this->category_uuid]))[0];
        $shop = Shop::collection((new ShopRepository())->findWhere(['uuid' => $this->shop_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_uuid' => $this->category_uuid,
            'shop_uuid' => $this->shop_uuid,
            'category' => $category,
            'shop' => $shop,
            'deliverer' => $this->deliverer,
            'identifier' => $this->identifier,
            'name' => $this->name,
            'price' => $this->price,
            'tax' => $this->tax,
            'url' => $this->url,
        ];
    }
}

