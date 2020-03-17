<?php

namespace NetLinker\WideStore\Sections\ShopCategories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\ShopCategories\Repositories\ShopCategoryRepository;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;
use NetLinker\WideStore\Sections\Shops\Resources\Shop;

class ShopCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $shop = Shop::collection((new ShopRepository())->findWhere(['uuid' => $this->shop_uuid]))[0];
        $parent = ShopCategory::collection((new ShopCategoryRepository())->findWhere(['uuid' => $this->parent_uuid]))[0] ?? null;

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'shop_uuid' => $this->shop_uuid,
            'parent_uuid' => $this->parent_uuid,
            'parent' => $parent,
            'shop' => $shop,
            'deliverer' => $this->deliverer,
            'name' => $this->name,
        ];
    }
}

