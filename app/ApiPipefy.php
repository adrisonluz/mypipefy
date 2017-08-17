<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class ApiPipefy extends Model
{
	public $key = '';
	public $myId = null;
	protected $organizationID = null;
	protected $pipeIds = [];

	private $curl;

	public function __construct(){
		$this->organizationID = Config::get('app.PIPEFY_ORGANIZATION_ID','');
		$this->pipeIds = [];
		
		$this->curl = curl_init();
	}

	public function __destruct(){
		curl_close($this->curl);
	}

	public function me(){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ me { id, name, username, avatar_url, email, locale, time_zone } }\"
		}");

		$responseArray = $this->runCurl();

		return $responseArray->data->me;
	}

	public function getUsers(){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id:".$this->organizationID."){ id, members { user { id, name, email, username, avatarUrl } } } }\"
		}");

		$responseArray = $this->runCurl();
		return $responseArray->data->organization->members;		
	}

	public function allPipes(){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ name, pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { name, id, phases { id, name, cards{  edges{ node { id, title, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");
		
		$pipesArray = $this->runCurl();

		return $pipesArray->data->organization;
	}

	public function myCards(){
		return $this->userCards($this->myId);
	}

	public function userCards($userId = null){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { id, name, phases { done, name, cards( search:{assignee_ids:[" . $userId. "]}) {  edges{ node { id, title, due_date, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");

		$pipesArray = $this->runCurl();

		$myPipes = [];
		foreach($pipesArray->data->organization->pipes as $pipe){
			$myCards = [];
			if(count($pipe->phases) > 0){
				foreach($pipe->phases as $phase){
					if(!$phase->done){
						foreach ($phase->cards as $card) {
							foreach ($card as $node) {
								$node->node->phaseName = $phase->name;
								$myCards[] = $node->node;
							}
						}
					}
				}
			}

			$myPipes[] = [
				'pipeId' => $pipe->id,
				'pipeName' => $pipe->name,
				'pipeCards' => $myCards
			];
		}

		return $myPipes;
	}

	public function onlyPipes(){
		$userId = (!empty($_POST['userId']) ? $_POST['userId'] : null);

		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ name, pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { name, id, phases { id, name, cards{ " . ($userId !== null ? "search:{assignee_ids:[" . $userId. "]})" : '') . "  edges{ node { id, title, due_date } } } } } } }\"
		}");

		$pipesArray = $this->runCurl();

		return $pipesArray->data->organization->pipes;
	}

	private function runCurl(){
		curl_setopt($this->curl, CURLOPT_URL, "https://app.pipefy.com/queries");
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($this->curl, CURLOPT_HEADER, FALSE);
		curl_setopt($this->curl, CURLOPT_POST, TRUE);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json",
		  "Authorization: Bearer " . $this->key
		));
		
		return json_decode(curl_exec($this->curl));
	} 

	public function getMyId($token){
		$this->key = $token;
		$me = $this->me();
		return $me->id;
	}
}
