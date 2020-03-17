<?php

namespace NetLinker\WideStore\Sections\Integrations\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Integrations\Repositories\IntegrationRepository;
use NetLinker\WideStore\Sections\Integrations\Requests\StoreIntegration;
use NetLinker\WideStore\Sections\Integrations\Requests\UpdateIntegration;
use NetLinker\WideStore\Sections\Integrations\Resources\Integration;

class IntegrationController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var IntegrationRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param IntegrationRepository $shopProducts
     */
    public function __construct(IntegrationRepository $shopProducts)
    {
        $this->shopProducts = $shopProducts;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.integrations.index', [
            'h1' => __('wide-store::integrations.integrations')
        ]);
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return Integration::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreIntegration $request
     * @return array
     */
    public function store(StoreIntegration $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::integrations.integration_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateIntegration $request
     * @param $id
     * @return array
     */
    public function update(UpdateIntegration $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::integrations.integration_was_successfully_updated'),
            new Integration($this->shopProducts->find($id))
        );
    }

    /**
     * Destroy
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        $this->shopProducts->scopeOwner()->destroy($id);

        return notify(__('wide-store::integrations.integration_was_successfully_deleted'));
    }

}
