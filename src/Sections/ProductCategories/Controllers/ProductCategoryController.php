<?php

namespace NetLinker\WideStore\Sections\ProductCategories\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\ProductCategories\Repositories\ProductCategoryRepository;
use NetLinker\WideStore\Sections\ProductCategories\Resources\ProductCategory;

class ProductCategoryController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ProductCategoryRepository $productCategories */
    protected $productCategories;

    /**
     * Constructor
     *
     * @param ProductCategoryRepository $productCategories
     */
    public function __construct(ProductCategoryRepository $productCategories)
    {
        $this->productCategories = $productCategories;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.product-categories.index', [
            'h1' => __('wide-store::product-categories.product_categories')
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
        return ProductCategory::collection(
            $this->productCategories->scope($request)
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
        $this->productCategories->create($request->all());
        return notify(__('wide-store::product-categories.product_category_was_successfully_updated'));
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
        $this->productCategories->update($request->all(), $id);

        return notify(
            __('wide-store::product-categories.product_category_was_successfully_updated'),
            new ProductCategory($this->productCategories->find($id))
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
        $this->productCategories->destroy($id);

        return notify(__('wide-store::product-categories.product_category_was_successfully_deleted'));
    }

}
