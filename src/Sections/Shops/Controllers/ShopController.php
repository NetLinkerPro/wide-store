<?php

namespace NetLinker\WideStore\Sections\Shops\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;
use NetLinker\WideStore\Sections\Shops\Requests\StoreShop;
use NetLinker\WideStore\Sections\Shops\Requests\UpdateShop;
use NetLinker\WideStore\Sections\Shops\Resources\Shop;

class ShopController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopRepository $shopProducts
     */
    public function __construct(ShopRepository $shopProducts)
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
        return view('wide-store::sections.shops.index', [
            'h1' => __('wide-store::shops.shops')
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
        return Shop::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShop $request
     * @return array
     */
    public function store(StoreShop $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shops.shop_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShop $request
     * @param $id
     * @return array
     */
    public function update(UpdateShop $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shops.shop_was_successfully_updated'),
            new Shop($this->shopProducts->find($id))
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

        return notify(__('wide-store::shops.shop_was_successfully_deleted'));
    }

}
