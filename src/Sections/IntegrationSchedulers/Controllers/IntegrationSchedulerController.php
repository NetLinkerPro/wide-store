<?php

namespace NetLinker\WideStore\Sections\IntegrationSchedulers\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Repositories\IntegrationSchedulerRepository;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Requests\StoreIntegrationScheduler;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Requests\UpdateIntegrationScheduler;
use NetLinker\WideStore\Sections\IntegrationSchedulers\Resources\IntegrationScheduler;

class IntegrationSchedulerController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var IntegrationSchedulerRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param IntegrationSchedulerRepository $shopProducts
     */
    public function __construct(IntegrationSchedulerRepository $shopProducts)
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
        return view('wide-store::sections.integration-schedulers.index', [
            'h1' => __('wide-store::integration-schedulers.integration_schedulers')
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
        return IntegrationScheduler::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreIntegrationScheduler $request
     * @return array
     */
    public function store(StoreIntegrationScheduler $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::integration-schedulers.integration_scheduler_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateIntegrationScheduler $request
     * @param $id
     * @return array
     */
    public function update(UpdateIntegrationScheduler $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::integration-schedulers.integration_scheduler_was_successfully_updated'),
            new IntegrationScheduler($this->shopProducts->find($id))
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

        return notify(__('wide-store::integration-schedulers.integration_scheduler_was_successfully_deleted'));
    }

}
