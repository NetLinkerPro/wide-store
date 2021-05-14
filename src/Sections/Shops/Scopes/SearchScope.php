<?php

namespace NetLinker\WideStore\Sections\Shops\Scopes;

use AwesIO\Repository\Scopes\ScopeAbstract;

class SearchScope extends ScopeAbstract
{
    public function scope($builder, $value, $scope)
    {
        return $builder->where('name','like', '%' . $value . '%');
    }
}
