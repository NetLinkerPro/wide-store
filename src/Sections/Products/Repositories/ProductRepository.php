<?php

namespace NetLinker\WideStore\Sections\Products\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Attributes\Models\Attribute;
use NetLinker\WideStore\Sections\Descriptions\Models\Description;
use NetLinker\WideStore\Sections\Identifiers\Models\Identifier;
use NetLinker\WideStore\Sections\Images\Models\Image;
use NetLinker\WideStore\Sections\Names\Models\Name;
use NetLinker\WideStore\Sections\Prices\Models\Price;
use NetLinker\WideStore\Sections\ProductCategories\Models\ProductCategory;
use NetLinker\WideStore\Sections\Products\Models\Product;
use NetLinker\WideStore\Sections\Products\Scopes\ProductScopes;
use NetLinker\WideStore\Sections\Stocks\Models\Stock;
use NetLinker\WideStore\Sections\Taxes\Models\Tax;
use NetLinker\WideStore\Sections\Urls\Models\Url;

class ProductRepository extends BaseRepository
{
    protected $searchable = [
        'deliverer'
    ];

    public function entity()
    {
        return Product::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new ProductScopes($request))->scope($this->entity);

        return $this;
    }

    /**
     * Delete a record by id.
     *
     * @param  int  $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        $results = $this->entity->where('id', $id)->delete();

        $this->reset();

        return $results;
    }

    /**
     * Delete all resources of product with product
     * Not delete category of product
     *
     * @param $id
     * @return void
     */
    public function forceDeleteWithResources($id): void{
        $product = Product::where('id', $id)->first(['id', 'uuid']);
        if (!$product){
            return;
        }
        $identifiers = Identifier::where('product_uuid', $product->uuid)->get();
        foreach ($identifiers as $identifier){
            $identifier->forceDelete();
        }
        $names = Name::where('product_uuid', $product->uuid)->get();
        foreach ($names as $name){
            $name->forceDelete();
        }
        $urls = Url::where('product_uuid', $product->uuid)->get();
        foreach ($urls as $url){
            $url->forceDelete();
        }
        $prices = Price::where('product_uuid', $product->uuid)->get();
        foreach ($prices as $price){
            $price->forceDelete();
        }
        $taxes = Tax::where('product_uuid', $product->uuid)->get();
        foreach ($taxes as $tax){
            $tax->forceDelete();
        }
        $stocks = Stock::where('product_uuid', $product->uuid)->get();
        foreach ($stocks as $stock){
            $stock->forceDelete();
        }
        $productCategories = ProductCategory::where('product_uuid', $product->uuid)->get();
        foreach ($productCategories as $productCategory){
            $productCategory->forceDelete();
        }
        $images = Image::where('product_uuid', $product->uuid)->get();
        foreach ($images as $image){
            $image->forceDelete();
        }
        $descriptions = Description::where('product_uuid', $product->uuid)->get();
        foreach ($descriptions as $description){
            $description->forceDelete();
        }
        $attributes = Attribute::where('product_uuid', $product->uuid)->get();
        foreach ($attributes as $attribute){
            $attribute->forceDelete();
        }
        $product->forceDelete();
    }

}
