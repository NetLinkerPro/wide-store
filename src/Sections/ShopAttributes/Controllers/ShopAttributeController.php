<?php

namespace NetLinker\WideStore\Sections\ShopAttributes\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopAttributes\Repositories\ShopAttributeRepository;
use NetLinker\WideStore\Sections\ShopAttributes\Requests\StoreShopAttribute;
use NetLinker\WideStore\Sections\ShopAttributes\Requests\UpdateShopAttribute;
use NetLinker\WideStore\Sections\ShopAttributes\Resources\ShopAttribute;

class ShopAttributeController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopAttributeRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopAttributeRepository $shopProducts
     */
    public function __construct(ShopAttributeRepository $shopProducts)
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
        return view('wide-store::sections.shop-attributes.index', [
            'h1' => __('wide-store::shop-attributes.attributes')
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
        return ShopAttribute::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopAttribute $request
     * @return array
     */
    public function store(StoreShopAttribute $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-attributes.attribute_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopAttribute $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopAttribute $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-attributes.attribute_was_successfully_updated'),
            new ShopAttribute($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-attributes.attribute_was_successfully_deleted'));
    }

}
