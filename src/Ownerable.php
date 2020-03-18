<?php


namespace NetLinker\WideStore;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Ownerable
{

    /**
     * Get auth owner uuid
     *
     * @return mixed
     */
    public function getAuthOwnerUuid(){

        /** @var Model $owner */
        $owner = $this->resolveDefaultOwner();
        return $owner->uuid;
    }



    /**
     * Get owner model name.
     *
     * @return string
     */
    protected function getOwnerModel()
    {
        return config('wide-store.owner.model');
    }

    /**
     * Resolve entity default owner.
     *
     * @return null|\Cog\Contracts\Ownership\CanBeOwner
     */
    public function resolveDefaultOwner()
    {
        $fieldUuid = config('wide-store.owner.field_auth_user_owner_uuid');
        $model = $this->getOwnerModel();
        return $model::where('uuid', Auth::user()->$fieldUuid)->first();
    }
}