<?php

namespace NetLinker\WideStore\Sections\ProductCategories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Categories\Resources\Category;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class ProductCategory extends JsonResource
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
        $category = Category::collection((new CategoryRepository())->findWhere(['uuid' => $this->category_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'product_uuid' => $this->product_uuid,
            'category_uuid' => $this->category_uuid,
            'deliverer' => $this->deliverer,
            'product' => $product,
            'category' => $category,
            'type' => $this->type,
        ];
    }
}

