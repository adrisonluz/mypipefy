<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;
use App\PipefyUser;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiPipefy $apiPipefy, PipefyUser $pipefyUser)
    {
        parent::__construct();
        $this->apiPipefy = $apiPipefy;
        $this->pipefyUser = $pipefyUser;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        self::pipefyAuth();
        $team = Auth::user()->team;
        $teamIds = [];
        foreach ($team as &$pipefyUser){
            $teamIds[] = $pipefyUser->pipefy_id;
            switch ($pipefyUser->pivot->status){
                case 0:
                    $pipefyUser->phase = 'add-team';
                    break;
                case 1:
                    $pipefyUser->phase = 'pending';
                    break;
                case 2:
                    $pipefyUser->phase = 'on-team';
                    break;
            }
        }
        $this->retorno['users'] = $this->pipefyUser->allAvailableUsers($teamIds);
        $this->retorno['myTeam'] = $team;
        return view('config', $this->retorno);
    }
}
