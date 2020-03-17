<?php

namespace NetLinker\WideStore\Sections\ShopProductCategories\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopProductCategories\Repositories\ShopProductCategoryRepository;
use NetLinker\WideStore\Sections\ShopProductCategories\Requests\StoreShopProductCategory;
use NetLinker\WideStore\Sections\ShopProductCategories\Requests\UpdateShopProductCategory;
use NetLinker\WideStore\Sections\ShopProductCategories\Resources\ShopProductCategory;

class ShopProductCategoryController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopProductCategoryRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopProductCategoryRepository $shopProducts
     */
    public function __construct(ShopProductCategoryRepository $shopProducts)
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
        return view('wide-store::sections.shop-product-categories.index', [
            'h1' => __('wide-store::shop-product-categories.product_categories')
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
        return ShopProductCategory::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopProductCategory $request
     * @return array
     */
    public function store(StoreShopProductCategory $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-product-categories.product_category_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopProductCategory $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopProductCategory $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-product-categories.product_category_was_successfully_updated'),
            new ShopProductCategory($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-product-categories.product_category_was_successfully_deleted'));
    }

}
