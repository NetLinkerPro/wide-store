<?php

namespace NetLinker\WideStore\Sections\Formatters\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Formatters\Services\Deliverer;

class FormatterController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /** @var Deliverer $deliverer */
    protected $deliverer;

    /**
     * Constructor
     *
     * @param Deliverer $deliverer
     */
    public function __construct(Deliverer $deliverer)
    {
        $this->deliverer = $deliverer;
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \NetLinker\WideStore\Exceptions\WideStoreException
     */
    public function scope(Request $request)
    {
        $resource = $this->deliverer->getClassResource($request->module);
        $repository = $this->deliverer->getRepository($request->module);

        return $resource::collection(
            $repository->scopeOwner()->scope($request)
                ->latest()->smartPaginate()
        );
    }

}
