<?php

namespace NetLinker\WideStore\Sections\Settings\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Settings\Repositories\SettingRepository;
use NetLinker\WideStore\Sections\Settings\Requests\StoreSetting;
use NetLinker\WideStore\Sections\Settings\Requests\UpdateSetting;
use NetLinker\WideStore\Sections\Settings\Resources\Setting;

class SettingController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var SettingRepository $shopProducts */
    protected $shopProducts;

    /**
     * Constructor
     *
     * @param SettingRepository $shopProducts
     */
    public function __construct(SettingRepository $shopProducts)
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
        return view('wide-store::sections.settings.index', [
            'h1' => __('wide-store::settings.settings')
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
        return Setting::collection(
            $this->shopProducts->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreSetting $request
     * @return array
     */
    public function store(StoreSetting $request)
    {
        $this->shopProducts->create($request->all());
        return notify(__('wide-store::settings.setting_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateSetting $request
     * @param $id
     * @return array
     */
    public function update(UpdateSetting $request, $id)
    {
        $this->shopProducts->update($request->all(), $id);

        return notify(
            __('wide-store::settings.setting_was_successfully_updated'),
            new Setting($this->shopProducts->find($id))
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
        $this->shopProducts->destroy($id);

        return notify(__('wide-store::settings.setting_was_successfully_deleted'));
    }

}
