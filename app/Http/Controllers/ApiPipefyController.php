<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use Auth;

class ApiPipefyController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy)
    {
        $this->apiPipefy = $apiPipefy;
    }

    public function getCardsUser(Request $request)
    {
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
                    'color' => $card->color,
    				'start' => $due,
                    'url' => $card->url
    			];
    		}
    	}

        return response()->json($cards);
    }

    public function getCardsUserTable(Request $request, $userId)
    {
        self::pipefyAuth(false);

        $userCards = $this->apiPipefy->userCards($userId);

        $css = '';
        $cards = [];
        $phases = [];
        foreach ($userCards as $pipe) {
            foreach ($pipe['pipeCards'] as $card) {
                $due = $card->due_date;

                if($due !== null){
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('d/m/Y');
                }else{
                    $due = "SEM DUE";
                }

                if(!in_array($card->phaseId, $phases)){
                    $phases[] = $card->phaseId; 
                    $css .= '.phase_'.$card->phaseId.' + .tooltip > .tooltip-inner{
                                background-color: '.$card->color.' !important;
                            }
                            .phase_'.$card->phaseId.' + .tooltip.right > .tooltip-arrow{
                                border-right-color: '.$card->color.' !important;
                            }
                            .phase_'.$card->phaseId.' + .tooltip.top > .tooltip-arrow{
                                border-top-color: '.$card->color.' !important;
                            }';
                }

                $cliente = '';
                foreach ($card->fields as $field) {
                    if($field->phase_field->id == 'cliente'){
                        $cliente = str_replace(['["','"]'], '', $field->value);
                    }
                }

                $cards[] = [
                    'cardId'     => $card->id,
                    'pipeName'   => $pipe['pipeName'],
                    'cardTitle'  => $card->title,
                    'clientName' => $cliente,
                    'due'        => $due,
                    'phaseName'  => $card->phaseName,
                    'phaseId'    => $card->phaseId,
                    'url'        => $card->url,
                    'pipeUrl'    => 'https://app.pipefy.com/pipes/'.$pipe['pipeId']
                ];
            }
        }

        return response()->json(['cards' => $cards, 'css' => $css]);
    }
}
