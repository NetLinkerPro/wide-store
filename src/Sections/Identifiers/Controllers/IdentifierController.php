<?php

namespace NetLinker\WideStore\Sections\Identifiers\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\FairQueue\Sections\Accesses\Requests\StoreAccess;
use NetLinker\WideStore\Sections\Identifiers\Repositories\IdentifierRepository;
use NetLinker\WideStore\Sections\Identifiers\Requests\SaveRelatedAuctionIdentifier;
use NetLinker\WideStore\Sections\Identifiers\Requests\SearchIdentifiersProductIdentifier;
use NetLinker\WideStore\Sections\Identifiers\Requests\SelectIdentifierProductIdentifier;
use NetLinker\WideStore\Sections\Identifiers\Requests\StoreIdentifier;
use NetLinker\WideStore\Sections\Identifiers\Requests\UpdateIdentifier;
use NetLinker\WideStore\Sections\Identifiers\Resources\Identifier;

class IdentifierController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var IdentifierRepository $identifiers */
    protected $identifiers;

    /**
     * Constructor
     *
     * @param IdentifierRepository $identifiers
     */
    public function __construct(IdentifierRepository $identifiers)
    {
        $this->identifiers = $identifiers;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.identifiers.index', [
            'h1' => __('wide-store::identifiers.identifiers')
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
        return Identifier::collection(
            $this->identifiers->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request store
     *
     * @param StoreIdentifier $request
     * @return array
     */
    public function store(StoreIdentifier $request)
    {
        $this->identifiers->create($request->all());
        return notify(__('wide-store::identifiers.identifier_was_successfully_updated'));
    }

    /**
     * Update
     *
     * @param UpdateIdentifier $request
     * @param $id
     * @return array
     */
    public function update(UpdateIdentifier $request, $id)
    {
        $this->identifiers->update($request->all(), $id);

        return notify(
            __('wide-store::identifiers.identifier_was_successfully_updated'),
            new Identifier($this->identifiers->find($id))
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
        $this->identifiers->destroy($id);

        return notify(__('wide-store::identifiers.identifier_was_successfully_deleted'));
    }

}
