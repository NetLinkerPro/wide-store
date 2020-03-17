<?php

namespace NetLinker\WideStore\Sections\IntegrationSchedulers\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Models\IntegrationScheduler;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Scopes\IntegrationSchedulerScopes;

class IntegrationSchedulerRepository extends BaseRepository
{
    protected $searchable = [];

    public function entity()
    {
        return IntegrationScheduler::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new IntegrationSchedulerScopes($request))->scope($this->entity);

        return $this;
    }

    public function scopeOwner()
    {
        $fieldUuid = config('wide-store.owner.field_auth_user_owner_uuid');
        $ownerUuid = Auth::user()->$fieldUuid;

        $this->entity = $this->entity->where('owner_uuid', $ownerUuid);

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
