<?php

namespace NetLinker\WideStore\Sections\Stocks\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Stocks\Repositories\StockRepository;
use NetLinker\WideStore\Sections\Stocks\Resources\Stock;

class StockController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var StockRepository $stocks */
    protected $stocks;

    /**
     * Constructor
     *
     * @param StockRepository $stocks
     */
    public function __construct(StockRepository $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.stocks.index', [
            'h1' => __('wide-store::stocks.stocks')
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
        return Stock::collection(
            $this->stocks->scope($request)
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
        $this->stocks->create($request->all());
        return notify(__('wide-store::stocks.stock_was_successfully_updated'));
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
        $this->stocks->update($request->all(), $id);

        return notify(
            __('wide-store::stocks.stock_was_successfully_updated'),
            new Stock($this->stocks->find($id))
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
        $this->stocks->destroy($id);

        return notify(__('wide-store::stocks.stock_was_successfully_deleted'));
    }

}
