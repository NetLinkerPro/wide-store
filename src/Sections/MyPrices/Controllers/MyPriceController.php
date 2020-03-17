<?php

namespace NetLinker\WideStore\Sections\MyPrices\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\MyPrices\Repositories\MyPriceRepository;
use NetLinker\WideStore\Sections\MyPrices\Requests\StoreMyPrice;
use NetLinker\WideStore\Sections\MyPrices\Requests\UpdateMyPrice;
use NetLinker\WideStore\Sections\MyPrices\Resources\MyPrice;

class MyPriceController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var MyPriceRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param MyPriceRepository $shopProducts
     */
    public function __construct(MyPriceRepository $shopProducts)
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
        return view('wide-store::sections.my-prices.index', [
            'h1' => __('wide-store::my-prices.prices')
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
        return MyPrice::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreMyPrice $request
     * @return array
     */
    public function store(StoreMyPrice $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::my-prices.price_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateMyPrice $request
     * @param $id
     * @return array
     */
    public function update(UpdateMyPrice $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::my-prices.price_was_successfully_updated'),
            new MyPrice($this->shopProducts->find($id))
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

        return notify(__('wide-store::my-prices.price_was_successfully_deleted'));
    }

}
