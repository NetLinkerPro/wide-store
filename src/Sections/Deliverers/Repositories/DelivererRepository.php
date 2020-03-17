<?php

namespace NetLinker\WideStore\Sections\Deliverers\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use NetLinker\WideStore\Sections\Deliverers\Models\Deliverer;
use NetLinker\WideStore\Sections\Descriptions\Models\Description;
use NetLinker\WideStore\Sections\Descriptions\Scopes\DescriptionScopes;

class DelivererRepository
{


    public function all()
    {
        return collect([
           new Deliverer(['name' => 'Pareto', 'value'=>'pareto'])
        ]);
    }
}
