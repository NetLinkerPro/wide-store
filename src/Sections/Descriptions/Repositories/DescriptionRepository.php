<?php

namespace NetLinker\WideStore\Sections\Descriptions\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Descriptions\Models\Description;
use NetLinker\WideStore\Sections\Descriptions\Scopes\DescriptionScopes;

class DescriptionRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Description::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new DescriptionScopes($request))->scope($this->entity);

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
