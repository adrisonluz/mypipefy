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
                $due = $card->due_date;

                if($due !== null){
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('Y-m-d');
                }

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
