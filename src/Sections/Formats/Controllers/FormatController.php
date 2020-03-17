<?php

namespace NetLinker\WideStore\Sections\Formats\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Formats\Repositories\FormatRepository;
use NetLinker\WideStore\Sections\Formats\Requests\StoreFormat;
use NetLinker\WideStore\Sections\Formats\Requests\UpdateFormat;
use NetLinker\WideStore\Sections\Formats\Resources\Format;

class FormatController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var FormatRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param FormatRepository $shopProducts
     */
    public function __construct(FormatRepository $shopProducts)
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
        return view('wide-store::sections.formats.index', [
            'h1' => __('wide-store::formats.formats')
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
        return Format::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreFormat $request
     * @return array
     */
    public function store(StoreFormat $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::formats.format_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateFormat $request
     * @param $id
     * @return array
     */
    public function update(UpdateFormat $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::formats.format_was_successfully_updated'),
            new Format($this->shopProducts->find($id))
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

        return notify(__('wide-store::formats.format_was_successfully_deleted'));
    }

}
