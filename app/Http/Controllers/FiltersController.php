<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;

class FiltersController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy)
    {
        parent::__construct($apiPipefy);
        $this->apiPipefy = $apiPipefy;
    }

    public function filters()
    {
        $this->retorno['filters'] = [];

        return view('filters.index', $this->retorno);
    }

    public function insert()
    {

    }

    public function edit()
    {

    }

    public function save()
    {

    }

}