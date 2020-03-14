<?php

namespace NetLinker\WideStore\Sections\Categories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class Category extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parentCategory = Category::collection((new CategoryRepository())->findWhere(['uuid' => $this->parent_uuid]))[0] ?? null;

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'parent_uuid' => $this->parent_uuid,
            'deliverer' => $this->deliverer,
            'parent_category' => $parentCategory,
            'name' => $this->name,
            'lang' => $this->lang,
            'type' => $this->type,
        ];
    }
}

