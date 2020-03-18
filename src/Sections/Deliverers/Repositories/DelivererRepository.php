<?php

namespace NetLinker\WideStore\Sections\Deliverers\Repositories;

use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Str;
use NetLinker\WideStore\Sections\Deliverers\Models\Deliverer;
use NetLinker\WideStore\Sections\Descriptions\Models\Description;
use NetLinker\WideStore\Sections\Descriptions\Scopes\DescriptionScopes;

class DelivererRepository
{

    /**
     * Scope
     *
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function scope($request)
    {
        $collect = collect();

        if ($request->q) {

            foreach ($this->all() as $deliverer) {
                if (Str::contains(mb_strtolower($deliverer->name), mb_strtolower($request->q))
                    || Str::contains(mb_strtolower($deliverer->value), mb_strtolower($request->q))) {
                    $collect->push($deliverer);
                }
            }
        } else {

            $collect = $this->all();
        }

        return $collect;
    }

    /**
     * Get all deliverers
     *
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $collect = collect();

        foreach ($this->listModules() as $module) {

            $name = $this->getName($module);

            $collect->push(new Deliverer(['name' => $name, 'value' => $module]));
        }

        return $collect;
    }

    /**
     * List  modules
     *
     * @return \Illuminate\Support\Collection
     */
    public function listModules()
    {
        $list = collect();

        foreach (glob(config('auto-deliverer-store.vendor') . '/netlinker/deliverer-*') as $filename) {

            $filenameExplode = explode('netlinker/deliverer-', $filename);

            if (sizeof($filenameExplode)) {

                $list->push(end($filenameExplode));

            }
        }

        return $list;
    }

    /**
     * Get name
     *
     * @param $module
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getName($module)
    {
        return config('deliverer-' . $module . '.name', $module);
    }
}
