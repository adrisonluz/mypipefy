<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;
use App\PipefyUser;
use App\TeamsReal;
use App\Members;

class TeamsController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy)
    {
        parent::__construct($apiPipefy);
        $this->apiPipefy = $apiPipefy;
    }

    public function teams()
    {
        self::pipefyAuth();
        $this->retorno['teams'] = TeamsReal::all();

        return view('teams.index', $this->retorno);
    }

    public function insert()
    {
        self::pipefyAuth();
        $this->retorno['team'] = new TeamsReal;
        $this->retorno['team']->fields = [];
        $this->retorno['members'] = PipefyUser::where('username', '<>', '')->orderBy('name', 'asc')->get();
        $this->retorno['members_selected'] = [];

        return view('teams.add', $this->retorno);
    }

    public function edit($team_id)
    {
        self::pipefyAuth();
        $this->retorno['team'] = TeamsReal::find($team_id);

        $this->retorno['members_selected'] = [];
        foreach ($this->retorno['team']->members as $member) {
            $this->retorno['members_selected'][] = $member->member_id;
        }

        $this->retorno['members'] = PipefyUser::where('username', '<>', '')->orderBy('name', 'asc')->get();

        return view('teams.add', $this->retorno);
    }

    public function save(Request $request)
    {
        $team = empty($request->id) ? new TeamsReal : TeamsReal::find($request->id);

        $team->name = $request->name;

        $team->save();

        $team->members()->delete();
        if (isset($request->member_id)) {
            foreach ($request->member_id as $member_id) {
                $member = new Members(['member_id' => $member_id]);

                $team->members()->save($member);
            }
        }

        return redirect()->route('config.teams.edit', $team->id)->with('status', 'Time salvo com sucesso!');
    }

    public function destroy($team_id)
    {
        TeamsReal::find($team_id)->delete();
        return redirect()->route('config.teams')->with('status', 'Time deletado com sucesso!');
    }
}