<?php

namespace NetLinker\WideStore\Sections\Check\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use NetLinker\AutoDelivererStore\Sections\Check\Repositories\CheckRepository;
use NetLinker\WideStore\Sections\Shops\Repositories\ShopRepository;

class CheckController extends BaseController
{

    use AuthorizesRequests, ValidatesRequests;

    /** @var CheckRepository $check */
    protected $check;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->check = app(CheckRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'status' =>'failes',
        ]);
    }

}
