<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if (!Auth::guest()) {
    		self::pipefyAuth();
        	return view('home', $this->retorno);
    	} else {
        	return view('home');
    	}
    }
}
