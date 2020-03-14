<?php

namespace NetLinker\WideStore\Sections\Prices\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Prices\Repositories\PriceRepository;
use NetLinker\WideStore\Sections\Prices\Resources\Price;

class PriceController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var PriceRepository $prices */
    protected $prices;

    /**
     * Constructor
     *
     * @param PriceRepository $prices
     */
    public function __construct(PriceRepository $prices)
    {
        $this->prices = $prices;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.prices.index', [
            'h1' => __('wide-store::prices.prices')
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
        return Price::collection(
            $this->prices->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->prices->create($request->all());
        return notify(__('wide-store::prices.price_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $this->prices->update($request->all(), $id);

        return notify(
            __('wide-store::prices.price_was_successfully_updated'),
            new Price($this->prices->find($id))
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
        $this->prices->destroy($id);

        return notify(__('wide-store::prices.price_was_successfully_deleted'));
    }

}
