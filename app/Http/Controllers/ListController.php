<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use App\PipefyUser;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy){
        $this->apiPipefy = $apiPipefy;
    }

    public function index()
    {
        self::pipefyAuth();
        $retorno['myCards'] = $this->apiPipefy->myCards();
        $retorno['allPipes'] = $this->apiPipefy->allPipes();
        $retorno['me'] = $this->apiPipefy->me();

        return view('dashboard', $retorno);
    }

    public function team()
    {
        self::pipefyAuth();
        $retorno['team'] = Auth::user()->teamActive;


        $retorno['me'] = $this->apiPipefy->me();

        return view('team', $retorno);
    }
}
