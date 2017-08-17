<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use App\PipefyUser;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiPipefy $apiPipefy, PipefyUser $pipefyUser)
    {
        $this->middleware('auth');
        $this->apiPipefy = $apiPipefy;
        $this->pipefyUser = $pipefyUser;
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
        $retorno['users'] = $this->pipefyUser->allUsers();
        return view('config', $retorno);
    }
}
