<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiPipefy;
use App\Filters;
use Auth;

class ApiPipefyController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy)
    {
        $this->apiPipefy = $apiPipefy;
    }

    public function getCardsUser($userId)
    {
        self::pipefyAuth(false);
        $arrUserIds = explode(';', $userId);
    	$userCards = $this->apiPipefy->userCards(implode(', ', $arrUserIds));

    	$cards = [];

    	foreach ($userCards as $pipes) {
    		foreach ($pipes['pipeCards'] as $card) {
                $due = $card->due_date;

                if ($due !== null) {
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('Y-m-d');
                } else {
                    $due = '0000-00-00';
                }

                $responsible = '';
                if(count($arrUserIds) > 1){                
                    foreach ($card->assignees as $assignee) {
                        if (in_array($assignee->id, $arrUserIds)) {
                            $responsible = FirstAndLastName($assignee->name);
                        }
                    }
                    $responsible = ' | '.$responsible;
                }

    			$cards[] = [
                    'title' => $card->title.$responsible,
                    'color' => $card->color,
                    'start' => $due,
                    'url'   => $card->url
    			];
    		}
    	}

        return response()->json($cards);
    }

    public function getCardsUserTable($userId)
    {
        self::pipefyAuth(false);
        $arrUserIds = explode(';', $userId);

        $userCards = $this->apiPipefy->userCards(implode(', ', $arrUserIds));

        $css = '';
        $cards = [];
        $phases = [];
        foreach ($userCards as $pipe) {
            foreach ($pipe['pipeCards'] as $card) {
                $due = $card->due_date;

                if ($due !== null) {
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('d/m/Y');
                } else {
                    $due = "SEM DUE";
                }

                if (!in_array($card->phaseId, $phases)) {
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
                    if ($field->phase_field->id == 'cliente') {
                        $cliente = str_replace(['["','"]'], '', $field->value);
                    }
                }

                $responsible = '';
                foreach ($card->assignees as $assignee) {
                    if (in_array($assignee->id, $arrUserIds)) {
                        $responsible = FirstAndLastName($assignee->name);
                    }
                }

                $cards[] = [
                    'cardId'     => $card->id,
                    'pipeName'   => $pipe['pipeName'],
                    'cardTitle'  => $card->title,
                    'clientName' => $cliente,
                    'due'        => $due,
                    'assignee'   => $responsible,
                    'phaseName'  => $card->phaseName,
                    'phaseId'    => $card->phaseId,
                    'url'        => $card->url,
                    'pipeUrl'    => 'https://app.pipefy.com/pipes/'.$pipe['pipeId']
                ];
            }
        }

        return response()->json(['cards' => $cards, 'css' => $css]);
    }

    public function getCardsFilter($filter_id)
    {
        self::pipefyAuth(false);
        $filter = Filters::find($filter_id);

        $filterCards = $this->apiPipefy->filterCards($filter);

        $filter->fields = json_decode($filter->fields);

        $fields_traducao = array(
            'title' => 'Título',
            'pipe' => 'Pipe',
            'client' => 'Cliente',
            'due' => 'DUE',
            'owner' => 'Criador',
            'assignee' => 'Responsável',
            'phase' => 'Fase',
        );

        // $fields = array_map(function($field) use ($fields_traducao){
        //     return [$field => $fields_traducao[$field]];
        // }, $filter->fields);

        $fields = [];
        foreach ($filter->fields as $field) {
            $fields[$field] = $fields_traducao[$field];
        }

        $cards = [];
        foreach ($filterCards as $pipe) {
            foreach ($pipe['pipeCards'] as $card) {
                $due = $card->due_date;

                if ($due !== null) {
                    $dateTime = new \DateTime($due);
                    $due = $dateTime->format('d/m/Y');
                    $due_calendar = $dateTime->format('Y-m-d');
                } else {
                    $due = "SEM DUE";
                    $due_calendar = '0000-00-00';
                }

                $cliente = '';
                foreach ($card->fields as $field) {
                    if ($field->phase_field->id == 'cliente') {
                        $cliente = json_decode($field->value);
                        $cliente = $cliente[0];
                    }
                }

                $assignees = implode(', ', array_map(function($assignee){
                    return $assignee->name;
                }, $card->assignees));

                $cards[] = [
                    'title'        => $card->title,
                    'client'       => $cliente,
                    'due'          => $due,
                    'due_calendar' => $due_calendar,
                    'assignee'     => $assignees,
                    'phase'        => $card->phaseName,
                    'pipe'         => $pipe['pipeName'],
                    'owner'        => $card->createdBy->name,
                    'card_id'      => $card->id,
                    'phase_id'     => $card->phaseId,
                    'url'          => $card->url,
                    'pipe_url'     => 'https://app.pipefy.com/pipes/'.$pipe['pipeId'],
                ];
            }
        }

        $response = [
            'fields' => $fields,
            'cards'  => $cards,
        ];

        return response()->json($response);
    }
}
