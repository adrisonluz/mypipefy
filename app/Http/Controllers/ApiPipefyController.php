<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;

class ApiPipefyController extends Controller
{
    public function getMe(ApiPipefy $apiPipefy){
        $pipes = $apiPipefy->me();

        return $pipes;
    }

    public function onlyPipes(ApiPipefy $apiPipefy){
        $pipes = $apiPipefy->onlyPipes();

        return $pipes;
    }

    public function getCardsUser(ApiPipefy $apiPipefy, Request $request){
    	$userId = $request->get('userId');

    	$userCards = $apiPipefy->userCards($userId);

    	$cards = [];
    	foreach ($userCards as $pipes) {
    		foreach ($pipes['pipeCards'] as $card) {
    			$due = '00/00/0000';

    			foreach ($card->fields as $field) {
    				if(strpos('data_prevista_de_entrega', $field->phase_field->id) !== false){
    					$due = substr($field->value,0,10);
					}
    			}

                $dueEx = explode('/',$due);
                $due = ($dueEx[2] . '-' . $dueEx[1] . '-' . $dueEx[0]);

    			$cards[] = [
    				'title' => $card->title,
    				'cardId' => $card->id,
    				'pipeId' => $pipes['pipeId'],
                    'phaseName' => $card->phaseName,
    				'start' => $due 
    			];
    		}
    	}

        return json_encode($cards);
    }
}
