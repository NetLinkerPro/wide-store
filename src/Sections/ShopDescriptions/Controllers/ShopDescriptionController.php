<?php

namespace NetLinker\WideStore\Sections\ShopDescriptions\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopDescriptions\Repositories\ShopDescriptionRepository;
use NetLinker\WideStore\Sections\ShopDescriptions\Requests\StoreShopDescription;
use NetLinker\WideStore\Sections\ShopDescriptions\Requests\UpdateShopDescription;
use NetLinker\WideStore\Sections\ShopDescriptions\Resources\ShopDescription;

class ShopDescriptionController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopDescriptionRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopDescriptionRepository $shopProducts
     */
    public function __construct(ShopDescriptionRepository $shopProducts)
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
        return view('wide-store::sections.shop-descriptions.index', [
            'h1' => __('wide-store::shop-descriptions.descriptions')
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
        return ShopDescription::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopDescription $request
     * @return array
     */
    public function store(StoreShopDescription $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-descriptions.description_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopDescription $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopDescription $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-descriptions.description_was_successfully_updated'),
            new ShopDescription($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-descriptions.description_was_successfully_deleted'));
    }

}
