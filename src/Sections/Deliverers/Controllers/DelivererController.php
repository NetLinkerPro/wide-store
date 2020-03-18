<?php

namespace NetLinker\WideStore\Sections\Deliverers\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Deliverers\Repositories\DelivererRepository;
use NetLinker\WideStore\Sections\Deliverers\Requests\StoreDeliverer;
use NetLinker\WideStore\Sections\Deliverers\Requests\UpdateDeliverer;
use NetLinker\WideStore\Sections\Deliverers\Resources\Deliverer;

class DelivererController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var DelivererRepository $deliverers */
    protected $deliverers;

    /**
     * Constructor
     *
     * @param DelivererRepository $deliverers
     */
    public function __construct(DelivererRepository $deliverers)
    {
        $this->deliverers = $deliverers;
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return Deliverer::collection(
            $this->deliverers->scope($request)
        );
    }

}
