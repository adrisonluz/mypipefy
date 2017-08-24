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
        self::pipefyAuth(false);

        $me = $this->apiPipefy->me();

        return $me;
    }

    public function onlyPipes(){
        self::pipefyAuth(false);

        $pipes = $this->apiPipefy->onlyPipes();

        return $pipes;
    }

    public function getCardsUser(Request $request){
        self::pipefyAuth(false);

    	$userId = $request->get('userId');

    	$userCards = $this->apiPipefy->userCards($userId);

    	$cards = [];
    	foreach ($userCards as $pipes) {
    		foreach ($pipes['pipeCards'] as $card) {
                $due = $card->due_date;

                if($due !== null){
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('Y-m-d');
                }else{
                    $due = '0000-00-00';
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

    public function getCardsUserTable(Request $request, $userId){
        self::pipefyAuth(false);

        $userCards = $this->apiPipefy->userCards($userId);

        $cards = [];
        foreach ($userCards as $pipe) {
            foreach ($pipe['pipeCards'] as $card) {
                $due = $card->due_date;

                if($due !== null){
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('d/m/Y');
                }else{
                    $due = "SEM DUE";
                }

                $cliente = '';
                foreach ($card->fields as $field) {
                    if($field->phase_field->id == 'cliente'){
                        $cliente = str_replace(['["','"]'], '', $field->value);
                    }
                }

                $cards[] = [
                    'cardId'     => $card->id,
                    'pipeId'     => $pipe['pipeId'],
                    'pipeName'   => $pipe['pipeName'],
                    'cardTitle'  => $card->title,
                    'clientName' => $cliente,
                    'due'        => $due,
                    'phaseName'  => $card->phaseName,
                ];
            }
        }

        return json_encode($cards);
    }
}
