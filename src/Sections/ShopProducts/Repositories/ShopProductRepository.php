<?php

namespace NetLinker\WideStore\Sections\ShopProducts\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use NetLinker\WideStore\Sections\ShopAttributes\Models\ShopAttribute;
use NetLinker\WideStore\Sections\ShopDescriptions\Models\ShopDescription;
use NetLinker\WideStore\Sections\ShopImages\Models\ShopImage;
use NetLinker\WideStore\Sections\ShopProductCategories\Models\ShopProductCategory;
use NetLinker\WideStore\Sections\ShopProducts\Models\ShopProduct;
use NetLinker\WideStore\Sections\ShopProducts\Scopes\ShopProductScopes;
use NetLinker\WideStore\Sections\ShopStocks\Models\ShopStock;

class ShopProductRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return ShopProduct::class;
    }

    public function scope($request)
    {
        parent::scope($request);

        $this->entity = (new ShopProductScopes($request))->scope($this->entity);

        return $this;
    }

    public function scopeOwner()
    {
        $fieldUuid = config('wide-store.owner.field_auth_user_owner_uuid');
        $ownerUuid = Auth::user()->$fieldUuid;

        $this->entity = $this->entity->where('owner_uuid', $ownerUuid);

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
        $product = ShopProduct::where('id', $id)->first(['id', 'uuid']);
        if (!$product){
            return;
        }
        $stocks = ShopStock::where('product_uuid', $product->uuid)->get();
        foreach ($stocks as $stock){
            $stock->forceDelete();
        }
        $productCategories = ShopProductCategory::where('product_uuid', $product->uuid)->get();
        foreach ($productCategories as $productCategory){
            $productCategory->forceDelete();
        }
        $images = ShopImage::where('product_uuid', $product->uuid)->get();
        foreach ($images as $image){
            $image->forceDelete();
        }
        $descriptions = ShopDescription::where('product_uuid', $product->uuid)->get();
        foreach ($descriptions as $description){
            $description->forceDelete();
        }
        $attributes = ShopAttribute::where('product_uuid', $product->uuid)->get();
        foreach ($attributes as $attribute){
            $attribute->forceDelete();
        }
        $product->forceDelete();
    }

}
