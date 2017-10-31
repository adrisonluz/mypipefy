<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\PipefyUser;
use App\PipeConfig;

class PipeConfigsController extends Controller
{
    public function save(Request $request)
    {
        $phase_ids = $request->get('phase_id');
        $colors = $request->get('color');
        
        //Deleta as configurações existentes
        PipeConfig::where('user_id', Auth::user()->id)->delete();

        //Inserindo novas configurações
        foreach($phase_ids as $i => $phase_id){
            $data = [
                'phase_id' => $phase_id,
                'color'    => $colors[$phase_id],
                'user_id'  => Auth::user()->id
            ];
            PipeConfig::create($data);
        }
        return redirect()->route('config.pipes')->with('status', 'Configurações salvas com sucesso!');
    }
}
