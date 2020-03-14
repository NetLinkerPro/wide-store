<?php

namespace NetLinker\WideStore\Sections\Names\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Names\Models\Name;
use NetLinker\WideStore\Sections\Names\Scopes\NameScopes;

class NameRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Name::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new NameScopes($request))->scope($this->entity);

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
