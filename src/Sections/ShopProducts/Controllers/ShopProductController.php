<?php

namespace NetLinker\WideStore\Sections\ShopProducts\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopProducts\Repositories\ShopProductRepository;
use NetLinker\WideStore\Sections\ShopProducts\Requests\StoreShopProduct;
use NetLinker\WideStore\Sections\ShopProducts\Requests\UpdateShopProduct;
use NetLinker\WideStore\Sections\ShopProducts\Resources\ShopProduct;

class ShopProductController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopProductRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopProductRepository $shopProducts
     */
    public function __construct(ShopProductRepository $shopProducts)
    {
        $this->shopProducts = $shopProducts;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.shop-products.index', [
            'h1' => __('wide-store::shop-products.products')
        ]);
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return ShopProduct::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopProduct $request
     * @return array
     */
    public function store(StoreShopProduct $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-products.product_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopProduct $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopProduct $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-products.product_was_successfully_updated'),
            new ShopProduct($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-products.product_was_successfully_deleted'));
    }

}
