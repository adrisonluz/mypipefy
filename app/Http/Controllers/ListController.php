<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use App\PipefyUser;
use Illuminate\Support\Facades\Auth;


class ListController extends Controller
{
    public function index()
    {
        self::pipefyAuth();
        
        return view('dashboard', $this->retorno);
    }

    public function team()
    {
        self::pipefyAuth();
        $this->retorno['team'] = Auth::user()->teamActive;

        return view('team', $this->retorno);
    }
}
