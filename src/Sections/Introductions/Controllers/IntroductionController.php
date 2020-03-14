<?php

namespace NetLinker\WideStore\Sections\Introductions\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class IntroductionController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('wide-store::sections.introductions.index',
            [
                'h1' => __('wide-store::introductions.introduction'),
            ]
        );
    }
}
