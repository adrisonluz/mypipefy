<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;

class ApiPipefyController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy){
        $this->apiPipefy = $apiPipefy;
    }

    public function getMe(){
        self::pipefyAuth();

        $me = $this->apiPipefy->me();

        return $me;
    }

    public function onlyPipes(){
        self::pipefyAuth();

        $pipes = $this->apiPipefy->onlyPipes();

        return $pipes;
    }

    public function getCardsUser(Request $request){
        self::pipefyAuth();

    	$userId = $request->get('userId');

    	$userCards = $this->apiPipefy->userCards($userId);

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
