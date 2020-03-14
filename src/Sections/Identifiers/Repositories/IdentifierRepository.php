<?php

namespace NetLinker\WideStore\Sections\Identifiers\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Identifiers\Models\Identifier;
use NetLinker\WideStore\Sections\Identifiers\Scopes\IdentifierScopes;

class IdentifierRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Identifier::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new IdentifierScopes($request))->scope($this->entity);

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
