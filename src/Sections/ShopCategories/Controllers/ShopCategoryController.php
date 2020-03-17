<?php

namespace NetLinker\WideStore\Sections\ShopCategories\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopCategories\Repositories\ShopCategoryRepository;
use NetLinker\WideStore\Sections\ShopCategories\Requests\StoreShopCategory;
use NetLinker\WideStore\Sections\ShopCategories\Requests\UpdateShopCategory;
use NetLinker\WideStore\Sections\ShopCategories\Resources\ShopCategory;

class ShopCategoryController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopCategoryRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopCategoryRepository $shopProducts
     */
    public function __construct(ShopCategoryRepository $shopProducts)
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
        return view('wide-store::sections.shop-categories.index', [
            'h1' => __('wide-store::shop-categories.categories')
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
        return ShopCategory::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopCategory $request
     * @return array
     */
    public function store(StoreShopCategory $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-categories.category_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopCategory $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopCategory $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-categories.category_was_successfully_updated'),
            new ShopCategory($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-categories.category_was_successfully_deleted'));
    }

}
