<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiPipefy $apiPipefy)
    {
        $this->middleware('auth');
        $this->apiPipefy = $apiPipefy;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::pipefyAuth();
        $retorno['me'] = $this->apiPipefy->me();
        return view('config', $retorno);
    }
}
