<?php

namespace NetLinker\WideStore\Sections\Products\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Categories\Resources\Category;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = Category::collection((new CategoryRepository())->findWhere(['uuid' => $this->category_uuid]))[0];

        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_uuid' => $this->category_uuid,
            'category' => $category,
            'deliverer' => $this->deliverer,
            'identifier' => $this->identifier,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}

