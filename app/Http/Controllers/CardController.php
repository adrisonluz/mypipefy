<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\ApiPipefy;
use app\PipefyUser;
use \DateTime;

class CardController extends Controller
{
    public function detailCard($cardId)
    {
    	self::pipefyAuth();

    	$card = $this->apiPipefy->cardDetail($cardId);

    	//Define assignees
    	foreach($card->assignees as &$assignee){
    		$pipefyUser = PipefyUser::find($assignee->id);
    		$assignee = $pipefyUser;
    		$assignee->avatar = $pipefyUser->avatar();
    	}

    	//Define Comment Author
    	foreach($card->comments as &$comment){
            $comment->text = markup($comment->text);
            
            $dateTime = new DateTime($comment->created_at);
            $comment->created_at = $dateTime->format('d/m/Y H:i');

    		$pipefyUser = PipefyUser::find($comment->author->id);
    		$comment->author = $pipefyUser;
    		$comment->author->avatar = $pipefyUser->avatar();
    	}

    	$alternativeFields = [];

    	$importantFields = [
			'Cliente',
			'Nome da Conta do CRM',
			'Atendimento',
			'Gerente',
    	];

    	//Define fields
    	foreach($card->fields as $field){
    		$field = json_decode(json_encode($field), true);

    		//Separate important fields
    		if(in_array($field['name'], $importantFields) && !in_array($field['name'], array_column($alternativeFields, 'name'))){
    			if(!is_null(json_decode($field['value']))){
    				$field['value'] = json_decode($field['value']);
    			}else{
    				$field['value'] = [$field['value']];
    			}
    			$alternativeFields[] = $field;
    		}

    		switch($field['name']){
    			case 'URL':
    				$card->siteUrl = $field['value'];
    				break;
    			case 'Print':
    				$attachments = json_decode($field['value']);
    				foreach($attachments as $attachment){
    					$attachmentExp = explode('/', $attachment);
    					$extension = strrchr(end($attachmentExp), '.');
    					$extension = ltrim($extension, '.');

    					//Define type as image
    					if(in_array(strtolower($extension), ['png', 'jpg', 'jpeg', 'bmp', 'gif', 'ico'])){
    						$imageType = 'image';
    					}else{
    						$imageType = 'file';
    					}

    					$card->attachments[] = [
    						'link' => $attachment,
    						'name' => end($attachmentExp),
    						'type' => $imageType,
    					];
    				}
    				
    				break;
    			case 'Observações':
    				$card->description = markup($field['value']);
    				break;
    		}
    	}

    	$alternativeFields[] = [
    		'name' => 'Fase Atual',
    		'value' => $card->current_phase->name,
    	];

    	//Phases History
        foreach($card->phases_history as &$phase){
            $dateTime = new DateTime($phase->firstTimeIn);
            $phaseNew = [
                'name' => $phase->phase->name,
                'date' => $dateTime->format('d/m/Y H:i'),
            ];
            $phase = $phaseNew;
        }

        //Format due
        $dateTime = new DateTime($card->due_date);
        $card->due_date = $dateTime->format('d/m/Y');

    	unset($card->fields);
    	$card->fields = $alternativeFields;
    	unset($card->current_phase);
		return response()->json($card);
    }
}
