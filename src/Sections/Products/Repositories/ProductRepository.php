<?php

namespace NetLinker\WideStore\Sections\Products\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Products\Models\Product;
use NetLinker\WideStore\Sections\Products\Scopes\ProductScopes;

class ProductRepository extends BaseRepository
{
    protected $searchable = [];

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

}
