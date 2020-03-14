<?php

namespace NetLinker\WideStore\Sections\Categories\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\WideStore\Sections\Categories\Repositories\CategoryRepository;
use NetLinker\WideStore\Sections\Categories\Resources\Category;

class CategoryController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var CategoryRepository $categories */
    protected $categories;

    /**
     * Constructor
     *
     * @param CategoryRepository $categories
     */
    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Request index
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('wide-store::sections.categories.index', [
            'h1' => __('wide-store::categories.categories')
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
        return Category::collection(
            $this->categories->scope($request)
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
        $this->categories->create($request->all());
        return notify(__('wide-store::categories.category_was_successfully_updated'));
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
        $this->categories->update($request->all(), $id);

        return notify(
            __('wide-store::categories.category_was_successfully_updated'),
            new Category($this->categories->find($id))
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
        $this->categories->destroy($id);

        return notify(__('wide-store::categories.category_was_successfully_deleted'));
    }

}
