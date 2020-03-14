<?php

namespace NetLinker\WideStore\Sections\Prices\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Prices\Models\Price;
use NetLinker\WideStore\Sections\Prices\Scopes\PriceScopes;

class PriceRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Price::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new PriceScopes($request))->scope($this->entity);

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
