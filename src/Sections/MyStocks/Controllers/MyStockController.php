<?php

namespace NetLinker\WideStore\Sections\MyStocks\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\MyStocks\Repositories\MyStockRepository;
use NetLinker\WideStore\Sections\MyStocks\Requests\StoreMyStock;
use NetLinker\WideStore\Sections\MyStocks\Requests\UpdateMyStock;
use NetLinker\WideStore\Sections\MyStocks\Resources\MyStock;

class MyStockController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var MyStockRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param MyStockRepository $shopProducts
     */
    public function __construct(MyStockRepository $shopProducts)
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
        return view('wide-store::sections.my-stocks.index', [
            'h1' => __('wide-store::my-stocks.stocks')
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
        return MyStock::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreMyStock $request
     * @return array
     */
    public function store(StoreMyStock $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::my-stocks.stock_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateMyStock $request
     * @param $id
     * @return array
     */
    public function update(UpdateMyStock $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::my-stocks.stock_was_successfully_updated'),
            new MyStock($this->shopProducts->find($id))
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

        return notify(__('wide-store::my-stocks.stock_was_successfully_deleted'));
    }

}
