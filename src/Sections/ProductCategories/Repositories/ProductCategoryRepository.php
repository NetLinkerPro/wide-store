<?php

namespace NetLinker\WideStore\Sections\ProductCategories\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\ProductCategories\Models\ProductCategory;
use NetLinker\WideStore\Sections\ProductCategories\Scopes\ProductCategoryScopes;

class ProductCategoryRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return ProductCategory::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new ProductCategoryScopes($request))->scope($this->entity);

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

}
