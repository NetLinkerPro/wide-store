<?php

namespace NetLinker\WideStore\Sections\Settings\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use NetLinker\WideStore\Sections\Settings\Models\Setting;
use NetLinker\WideStore\Sections\Settings\Scopes\SettingScopes;

class SettingRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return Setting::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new SettingScopes($request))->scope($this->entity);

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
