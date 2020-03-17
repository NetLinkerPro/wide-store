<?php

namespace NetLinker\WideStore\Sections\ShopProductCategories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\ShopCategories\Repositories\ShopCategoryRepository;
use NetLinker\WideStore\Sections\ShopCategories\Resources\ShopCategory;
use NetLinker\WideStore\Sections\ShopProductCategories\Repositories\ShopProductCategoryRepository;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;
use NetLinker\WideStore\Sections\ShopProducts\Resources\ShopProduct;
use NetLinker\WideStore\Sections\Shops\Resources\Shop;

class ShopProductCategory extends JsonResource
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
        $product = ShopProduct::collection((new ShopProductRepository())->findWhere(['uuid' => $this->product_uuid]))[0];
        $category = ShopCategory::collection((new ShopCategoryRepository())->findWhere(['uuid' => $this->category_uuid]))[0] ?? null;

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'shop_uuid' => $this->shop_uuid,
            'shop' => $shop,
            'product_uuid' => $this->product_uuid,
            'product' => $product,
            'category_uuid' => $this->category_uuid,
            'category' => $category,
            'deliverer' => $this->deliverer,
        ];
    }
}

