<?php

namespace NetLinker\WideStore\Sections\Images\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Images\Models\Image;
use NetLinker\WideStore\Sections\Images\Scopes\ImageScopes;

class ImageRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Image::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new ImageScopes($request))->scope($this->entity);

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
