<?php

namespace NetLinker\WideStore\Sections\Urls\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Urls\Models\Url;
use NetLinker\WideStore\Sections\Urls\Scopes\UrlScopes;

class UrlRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Url::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new UrlScopes($request))->scope($this->entity);

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
