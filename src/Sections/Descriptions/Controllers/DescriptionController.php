<?php

namespace NetLinker\WideStore\Sections\Descriptions\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Descriptions\Repositories\DescriptionRepository;
use NetLinker\WideStore\Sections\Descriptions\Resources\Description;

class DescriptionController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var DescriptionRepository $descriptions */
    protected $descriptions;

    /**
     * Constructor
     *
     * @param DescriptionRepository $descriptions
     */
    public function __construct(DescriptionRepository $descriptions)
    {
        $this->descriptions = $descriptions;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.descriptions.index', [
            'h1' => __('wide-store::descriptions.descriptions')
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
        return Description::collection(
            $this->descriptions->scope($request)
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
        $this->descriptions->create($request->all());
        return notify(__('wide-store::descriptions.description_was_successfully_updated'));
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
        $this->descriptions->update($request->all(), $id);

        return notify(
            __('wide-store::descriptions.description_was_successfully_updated'),
            new Description($this->descriptions->find($id))
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
        $this->descriptions->destroy($id);

        return notify(__('wide-store::descriptions.description_was_successfully_deleted'));
    }

}
