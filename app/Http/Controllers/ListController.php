<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;

class ListController extends Controller
{
    public function __construct(){
        $this->styles[] = 'https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/datatables.min.css';
    }

    public function index()
    {
        $apiPipefy = new ApiPipefy();
        $retorno['myCards'] = $apiPipefy->myCards();
        $retorno['allPipes'] = $apiPipefy->allPipes();
        $retorno['me'] = $apiPipefy->me();

        return view('dashboard', $retorno);
    }

    public function team()
    {
        $teamIds = [93148, 83854, 83852];
        $retorno['team'] = [];

        $apiPipefy = new ApiPipefy();
        foreach ($teamIds as $teamId) {
            $retorno['team'][] = $apiPipefy->myCards($teamId);
        }

        return view('team', $retorno);
    }
}
