<?php

namespace NetLinker\WideStore\Sections\Attributes\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Attributes\Repositories\AttributeRepository;
use NetLinker\WideStore\Sections\Attributes\Requests\StoreAttribute;
use NetLinker\WideStore\Sections\Attributes\Requests\UpdateAttribute;
use NetLinker\WideStore\Sections\Attributes\Resources\Attribute;

class AttributeController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var AttributeRepository $attributes */
    protected $attributes;

    /**
     * Constructor
     *
     * @param AttributeRepository $attributes
     */
    public function __construct(AttributeRepository $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.attributes.index', [
            'h1' => __('wide-store::attributes.attributes')
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
        return Attribute::collection(
            $this->attributes->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreAttribute $request
     * @return array
     */
    public function store(StoreAttribute $request)
    {
        $this->attributes->create($request->all());
        return notify(__('wide-store::attributes.attribute_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(UpdateAttribute $request, $id)
    {
        $this->attributes->update($request->all(), $id);

        return notify(
            __('wide-store::attributes.attribute_was_successfully_updated'),
            new Attribute($this->attributes->find($id))
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
        $this->attributes->destroy($id);

        return notify(__('wide-store::attributes.attribute_was_successfully_deleted'));
    }

}
