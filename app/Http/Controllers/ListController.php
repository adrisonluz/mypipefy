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
        
        return view('dashboards.me', $this->retorno);
    }

    public function team()
    {
        self::pipefyAuth();
        $this->retorno['team'] = Auth::user()->teamActive;

        return view('dashboards.team', $this->retorno);
    }

    public function general()
    {
        self::pipefyAuth();
        $team = Auth::user()->teamActive;
        unset($this->retorno['pipefyUser']);
        $userids = [];

        $userids[] = $this->retorno['me']->pipefy_id;
        foreach ($team as $member) {
            $userids[] = $member->pipefy_id;
        }

        $this->retorno['pipefy_ids'] = implode(';', $userids);

        return view('dashboards.general', $this->retorno);
    }
}
