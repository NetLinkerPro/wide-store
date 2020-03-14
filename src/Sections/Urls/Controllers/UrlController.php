<?php

namespace NetLinker\WideStore\Sections\Urls\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Urls\Repositories\UrlRepository;
use NetLinker\WideStore\Sections\Urls\Requests\StoreUrl;
use NetLinker\WideStore\Sections\Urls\Requests\UpdateUrl;
use NetLinker\WideStore\Sections\Urls\Resources\Url;

class UrlController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var UrlRepository $urls */
    protected $urls;

    /**
     * Constructor
     *
     * @param UrlRepository $urls
     */
    public function __construct(UrlRepository $urls)
    {
        $this->urls = $urls;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.urls.index', [
            'h1' => __('wide-store::urls.urls')
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
        return Url::collection(
            $this->urls->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreUrl $request
     * @return array
     */
    public function store(StoreUrl $request)
    {
        $this->urls->create($request->all());
        return notify(__('wide-store::urls.url_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateUrl $request
     * @param $id
     * @return array
     */
    public function update(UpdateUrl $request, $id)
    {
        $this->urls->update($request->all(), $id);

        return notify(
            __('wide-store::urls.url_was_successfully_updated'),
            new Url($this->urls->find($id))
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
        $this->urls->destroy($id);

        return notify(__('wide-store::urls.url_was_successfully_deleted'));
    }

}
