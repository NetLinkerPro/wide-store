<?php

namespace NetLinker\WideStore\Sections\Attributes\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Attributes\Models\Attribute;
use NetLinker\WideStore\Sections\Attributes\Scopes\AttributeScopes;

class AttributeRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Attribute::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new AttributeScopes($request))->scope($this->entity);

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
