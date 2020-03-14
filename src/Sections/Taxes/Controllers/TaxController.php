<?php

namespace NetLinker\WideStore\Sections\Taxes\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Taxes\Repositories\TaxRepository;
use NetLinker\WideStore\Sections\Taxes\Resources\Tax;

class TaxController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var TaxRepository $taxes */
    protected $taxes;

    /**
     * Constructor
     *
     * @param TaxRepository $taxes
     */
    public function __construct(TaxRepository $taxes)
    {
        $this->taxes = $taxes;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.taxes.index', [
            'h1' => __('wide-store::taxes.taxes')
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
        return Tax::collection(
            $this->taxes->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreAccess $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->taxes->create($request->all());
        return notify(__('wide-store::taxes.tax_was_successfully_updated'));
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
        $this->taxes->update($request->all(), $id);

        return notify(
            __('wide-store::taxes.tax_was_successfully_updated'),
            new Tax($this->taxes->find($id))
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
        $this->taxes->destroy($id);

        return notify(__('wide-store::taxes.tax_was_successfully_deleted'));
    }

}
