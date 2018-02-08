<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;
use App\PipefyUser;
use App\PipeConfig;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiPipefy $apiPipefy, PipefyUser $pipefyUser)
    {
        parent::__construct($apiPipefy);
        $this->apiPipefy = $apiPipefy;
        $this->pipefyUser = $pipefyUser;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function team()
    {
        self::pipefyAuth();
        $team = Auth::user()->team;
        $teamIds = [];
        foreach ($team as &$pipefyUser) {
            $teamIds[] = $pipefyUser->pipefy_id;
            switch ($pipefyUser->pivot->status) {
                case 0:
                    $pipefyUser->phase = 'add-team btn-success';
                    break;
                case 1:
                    $pipefyUser->phase = 'pending btn-warning';
                    break;
                case 2:
                    $pipefyUser->phase = 'on-team btn-danger';
                    break;
            }
        }
        $this->retorno['users'] = $this->pipefyUser->allAvailableUsers($teamIds);
        $this->retorno['myTeam'] = $team;
        return view('config', $this->retorno);
    }

    public function pipes()
    {
        self::pipefyAuth();
        $configs = PipeConfig::where('user_id', Auth::user()->id)->get();
        $pipes = $this->apiPipefy->onlyPipes();
        $conf = [];

        foreach ($configs as $config) {
            $conf[$config->phase_id] = $config->color;
        }

        foreach ($pipes as &$pipe) {
            foreach ($pipe->phases as &$phase) {
                $phase->checked = array_key_exists($phase->id, $conf) ? 'checked' : '';
                $phase->color = array_key_exists($phase->id, $conf) ? $conf[$phase->id] : '';
            }
        }

        $this->retorno['pipes'] = $pipes;
        return view('pipes', $this->retorno);        
    }
}
