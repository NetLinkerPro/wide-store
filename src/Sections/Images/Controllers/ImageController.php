<?php

namespace NetLinker\WideStore\Sections\Images\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Images\Repositories\ImageRepository;
use NetLinker\WideStore\Sections\Images\Resources\Image;

class ImageController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var ImageRepository $images */
    protected $images;

    /**
     * Constructor
     *
     * @param ImageRepository $images
     */
    public function __construct(ImageRepository $images)
    {
        $this->images = $images;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.images.index', [
            'h1' => __('wide-store::images.images')
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
        return Image::collection(
            $this->images->scope($request)
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
        $this->images->create($request->all());
        return notify(__('wide-store::images.image_was_successfully_updated'));
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
        $this->images->update($request->all(), $id);

        return notify(
            __('wide-store::images.image_was_successfully_updated'),
            new Image($this->images->find($id))
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
        $this->images->destroy($id);

        return notify(__('wide-store::images.image_was_successfully_deleted'));
    }

}
