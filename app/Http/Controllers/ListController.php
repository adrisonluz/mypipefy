<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use App\PipefyUser;
use App\Filters;
use Illuminate\Support\Facades\Auth;
use Gate;
use App;

class ListController extends Controller
{
    public function index()
    {
        self::pipefyAuth();

        return view('dashboards.me', $this->retorno);
    }

    public function team()
    {
        if (Gate::denies('is-manager')) {
            return redirect()->route('config.team')->with('status', 'Não há membros no seu time. Convide-os agora mesmo!');
        }

        self::pipefyAuth();
        $this->retorno['team'] = Auth::user()->teamActive;

        return view('dashboards.team', $this->retorno);
    }

    public function general()
    {
        if (Gate::denies('is-manager')) {
            return redirect()->route('config.team')->with('status', 'Não há membros no seu time. Convide-os agora mesmo!');
        }

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

    public function filters()
    {
        self::pipefyAuth();
        $this->retorno['filters'] = Auth::user()->filters;
        return view('dashboards.filters', $this->retorno);
    }
}
