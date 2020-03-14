<?php

namespace NetLinker\WideStore\Sections\Images\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class Image extends JsonResource
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
            'identifier' => $this->identifier,
            'url_source' => $this->url_source,
            'path' => $this->path,
            'disk' => $this->disk,
            'url_target' => $this->url_target,
            'order' => $this->order,
            'main' => $this->main,
            'active' => $this->active,
            'lang' => $this->lang,
            'type' => $this->type,
        ];
    }
}

