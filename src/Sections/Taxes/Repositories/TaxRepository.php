<?php

namespace NetLinker\WideStore\Sections\Taxes\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Taxes\Models\Tax;
use NetLinker\WideStore\Sections\Taxes\Scopes\TaxScopes;

class TaxRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Tax::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new TaxScopes($request))->scope($this->entity);

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
