<?php

namespace NetLinker\WideStore\Sections\Shops\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use NetLinker\WideStore\Sections\Shops\Models\Shop;
use NetLinker\WideStore\Sections\Shops\Scopes\ShopScopes;

class ShopRepository extends BaseRepository
{
    protected $searchable = [
        'deliverer' => 'like',
    ];

    public function entity()
    {
        return Shop::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new ShopScopes($request))->scope($this->entity);

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
