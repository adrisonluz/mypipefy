<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;

class ApiPipefyController extends Controller
{
    public function getMe(ApiPipefy $apiPipefy){
        $pipes = $apiPipefy->me();

        return $pipes;
    }

    public function onlyPipes(ApiPipefy $apiPipefy){
        $pipes = $apiPipefy->onlyPipes();

        return $pipes;
    }
}
