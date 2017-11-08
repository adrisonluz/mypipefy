<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;
use App\Team;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $retorno;
    public $apiPipefy;

    public function __construct(ApiPipefy $apiPipefy)
    {
        $this->apiPipefy = $apiPipefy;
    }

    protected function pipefyAuth($withMe = true)
    {
    	$this->apiPipefy->key = Auth::user()->token;
    	$this->apiPipefy->myId = Auth::user()->pipefy_id;
    	
    	if ($withMe) {
            $this->retorno['me'] = Auth::user()->pipefyUser;
            $this->retorno['pipefyUser'] = $this->retorno['me'];
            $this->retorno['invites'] = Team::invites(Auth::user()->pipefy_id);
        }
    }
}
