<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;


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
        $teamIds = [93148, 83854, 83852];
        $retorno['team'] = [];

        foreach ($teamIds as $teamId) {
            $retorno['team'][$teamId] = $this->apiPipefy->userCards($teamId);
        }

        $retorno['me'] = $this->apiPipefy->me();
        $retorno['allPipes'] = $this->apiPipefy->allPipes();

        return view('team', $retorno);
    }
}
