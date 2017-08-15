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

    public function getCardsUserTable(Request $request, $userId){
        self::pipefyAuth();

        $userCards = $this->apiPipefy->userCards($userId);

        $cards = [];
        foreach ($userCards as $pipe) {
            foreach ($pipe['pipeCards'] as $card) {
                $due = $card->due_date;

                if($due !== null){
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('d/m/Y');
                }

                $cliente = '';
                foreach ($card->fields as $field) {
                    if($field->phase_field->id == 'cliente'){
                        $cliente = str_replace(['["','"]'], '', $field->value);
                    }
                }

                $cards[] = [
                    'link_card'   => '<a href="https://app.pipefy.com/pipes/'.$pipe['pipeId'].'#cards/'.$card->id.'" target="_blank">'.$card->id.'</a>',
                    'link_pipe'   => '<a href="https://app.pipefy.com/pipes/'.$pipe['pipeId'].'" target="_blank">'.$pipe['pipeName'].'</a>',
                    'card_title'  => $card->title,
                    'client_name' => $cliente,
                    'due'         => $due,
                    'phaseName'   => $card->phaseName,
                ];
            }
        }

        return json_encode($cards);
    }
}
