<?php

namespace NetLinker\WideStore\Sections\Names\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Names\Repositories\NameRepository;
use NetLinker\WideStore\Sections\Names\Resources\Name;

class NameController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var NameRepository $names */
    protected $names;

    /**
     * Constructor
     *
     * @param NameRepository $names
     */
    public function __construct(NameRepository $names)
    {
        $this->names = $names;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.names.index', [
            'h1' => __('wide-store::names.names')
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
        return Name::collection(
            $this->names->scope($request)
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
        $this->names->create($request->all());
        return notify(__('wide-store::names.name_was_successfully_updated'));
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
        $this->names->update($request->all(), $id);

        return notify(
            __('wide-store::names.name_was_successfully_updated'),
            new Name($this->names->find($id))
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
        $this->names->destroy($id);

        return notify(__('wide-store::names.name_was_successfully_deleted'));
    }

}
