<?php

namespace NetLinker\WideStore\Sections\Products\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Products\Repositories\ProductRepository;
use NetLinker\WideStore\Sections\Products\Resources\Product;

class ProductController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ProductRepository $products */
    protected $products;

    /**
     * Constructor
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.products.index', [
            'h1' => __('wide-store::products.products')
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
        return Product::collection(
            $this->products->scope($request)
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
        $this->products->create($request->all());
        return notify(__('wide-store::products.product_was_successfully_updated'));
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
        $this->products->update($request->all(), $id);

        return notify(
            __('wide-store::products.product_was_successfully_updated'),
            new Product($this->products->find($id))
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
        $this->products->destroy($id);

        return notify(__('wide-store::products.product_was_successfully_deleted'));
    }

}
