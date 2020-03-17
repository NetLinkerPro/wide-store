<?php

namespace NetLinker\WideStore\Sections\ShopStocks\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopStocks\Repositories\ShopStockRepository;
use NetLinker\WideStore\Sections\ShopStocks\Requests\StoreShopStock;
use NetLinker\WideStore\Sections\ShopStocks\Requests\UpdateShopStock;
use NetLinker\WideStore\Sections\ShopStocks\Resources\ShopStock;

class ShopStockController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopStockRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopStockRepository $shopProducts
     */
    public function __construct(ShopStockRepository $shopProducts)
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
        return view('wide-store::sections.shop-stocks.index', [
            'h1' => __('wide-store::shop-stocks.stocks')
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
        return ShopStock::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopStock $request
     * @return array
     */
    public function store(StoreShopStock $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-stocks.stock_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopStock $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopStock $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-stocks.stock_was_successfully_updated'),
            new ShopStock($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-stocks.stock_was_successfully_deleted'));
    }

}
