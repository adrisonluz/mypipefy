<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;

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
}
