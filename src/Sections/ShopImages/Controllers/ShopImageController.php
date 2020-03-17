<?php

namespace NetLinker\WideStore\Sections\ShopImages\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\ShopImages\Repositories\ShopImageRepository;
use NetLinker\WideStore\Sections\ShopImages\Requests\StoreShopImage;
use NetLinker\WideStore\Sections\ShopImages\Requests\UpdateShopImage;
use NetLinker\WideStore\Sections\ShopImages\Resources\ShopImage;

class ShopImageController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ShopImageRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param ShopImageRepository $shopProducts
     */
    public function __construct(ShopImageRepository $shopProducts)
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
        return view('wide-store::sections.shop-images.index', [
            'h1' => __('wide-store::shop-images.images')
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
        return ShopImage::collection(
            $this->shopProducts->scope($request)
                ->scopeOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreShopImage $request
     * @return array
     */
    public function store(StoreShopImage $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::shop-images.image_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateShopImage $request
     * @param $id
     * @return array
     */
    public function update(UpdateShopImage $request, $id)
    {
        $this->shopProducts->scopeOwner()->update($request->all(), $id);

        return notify(
            __('wide-store::shop-images.image_was_successfully_updated'),
            new ShopImage($this->shopProducts->find($id))
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

        return notify(__('wide-store::shop-images.image_was_successfully_deleted'));
    }

}
