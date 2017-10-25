<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Team;
use App\PipefyUser;
use App\Mail\SendInvite;

class TeamController extends Controller
{
    public function sendInvite(Request $request){
        return self::changeStatus($request, 1);
    }

    public function RemoveInvite(Request $request){
        return self::changeStatus($request, 0);
    }

    private function changeStatus(Request $request, $status){
        $team = Team::updateOrCreate([
            'user_id'   => Auth::user()->id,
            'pipefy_id' => $request->get('pipefy_id'),
        ]);

        $team->user_id   = Auth::user()->id;
        $team->pipefy_id = $request->get('pipefy_id');
        $team->status    = $status;
        $team->order     = 0;
        
        //if($team->save()){
            //$userPipefy = PipefyUser::find($team->pipefy_id);
            $userPipefy = PipefyUser::find($request->get('pipefy_id'));
            $nome_lider = Auth::user()->name;
            $email_convidado = $userPipefy->email;

            $dados = [
                'nome_lider' => Auth::user()->name,
                'nome_convidado' => $userPipefy->name
            ];

            \Mail::to($userPipefy)->send(new SendInvite($userPipefy));
        //}
            dd('fim');

        return json_encode(['success' => $team->save()]);
    }

    public function reorder(Request $request){
        foreach($request->get('order') as $order => $pipefy_id){
            $team = Team::updateOrCreate([
                'user_id'   => Auth::user()->id,
                'pipefy_id' => $pipefy_id,
            ]);

            $team->user_id   = Auth::user()->id;
            $team->pipefy_id = $pipefy_id;
            $team->order     = $order;

            $team->save();
        }
    }

    public function changeInvite(Request $request){
        $team = Team::find($request->get('teamId'));
        $team->status = $request->get('status');
        return json_encode(['success' => $team->save()]);
    }
}
