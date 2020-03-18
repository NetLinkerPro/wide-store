<?php


namespace NetLinker\WideStore\Sections\Configurations\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NetLinker\WideStore\Exceptions\WideStoreException;

class Deliverer
{

    /**
     * Get class resource
     *
     * @param string $deliverer
     * @return string
     * @throws WideStoreException
     */
    public function getClassResource(string $deliverer)
    {
        $classResource = sprintf('NetLinker\Deliverer%1$s\Sections\Configurations\Resources\Configuration', Str::ucfirst($deliverer));

        if (!class_exists($classResource)){
            throw new WideStoreException('Not found class ' . $classResource);
        }

        return $classResource;
    }

    /**
     * Get repository
     *
     * @param $deliverer
     * @return string
     * @throws WideStoreException
     */
    public function getRepository($deliverer)
    {
        $classRepository = $this->getClassRepository($deliverer);
        return new $classRepository();
    }

    /**
     * Get class repository
     *
     * @param $module
     * @return string
     * @throws WideStoreException
     */
    public function getClassRepository($module)
    {
        $classRepository = sprintf('NetLinker\Deliverer%1$s\Sections\Configurations\Repositories\ConfigurationRepository', Str::ucfirst($module));

        if (!class_exists($classRepository)){
            throw new WideStoreException('Not found class ' . $classRepository);
        }

        return $classRepository;
    }
}