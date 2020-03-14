<?php

namespace NetLinker\WideStore\Sections\Stocks\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Stocks\Models\Stock;
use NetLinker\WideStore\Sections\Stocks\Scopes\StockScopes;

class StockRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Stock::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new StockScopes($request))->scope($this->entity);

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
