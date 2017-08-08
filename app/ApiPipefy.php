<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class ApiPipefy extends Model
{
	protected $key = '';
	protected $myId = null;
	protected $organizationID = null;
	protected $pipeIds = [];

	public $curl;

	public function __construct(){
		$this->key = Config::get('app.PIPEFY_KEY','');
		$this->myId = Config::get('app.PIPEFY_MY_ID','');
		$this->organizationID = Config::get('app.PIPEFY_ORGANIZATION_ID','');
		$this->pipeIds = explode(',',Config::get('app.PIPEFY_PIPE_IDS',''));

		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_URL, "https://app.pipefy.com/queries");
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->curl, CURLOPT_HEADER, FALSE);
		curl_setopt($this->curl, CURLOPT_POST, TRUE);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json",
		  "Authorization: Bearer " . $this->key
		));
	}

	public function __destruct(){
		curl_close($this->curl);
	}

	public function me(){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ me { id, name, username, avatar_url, email, locale, time_zone } }\"
		}");

		$response = curl_exec($this->curl);
		$responseArray = json_decode($response);

		return $responseArray->data->me;
	}

	public function allPipes(){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ name, pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { name, id, phases { id, name, cards{  edges{ node { id, title, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");
		
		$response = curl_exec($this->curl);
		$pipesArray = json_decode($response);

		return $pipesArray->data->organization;
	}

	public function myCards(){
		return $this->userCards($this->myId);
	}

	public function userCards($userId = null){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { id, name, phases { cards( search:{assignee_ids:[" . $userId. "]}) {  edges{ node { id, title, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");

		$response = curl_exec($this->curl);
		$pipesArray = json_decode($response);

		$myPipes = [];
		foreach($pipesArray->data->organization->pipes as $pipe){
			$myCards = [];
			if(count($pipe->phases) > 0){
				foreach($pipe->phases as $phase){
					foreach ($phase->cards as $card) {
						foreach ($card as $node) {
							$myCards[] = $node->node;
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
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ name, pipes" . (!empty($this->pipeIds) ? "(ids: [" . implode($this->pipeIds, ',') . "])" : '') . " { name, id, phases { id, name, cards{ " . ($userId !== null ? "search:{assignee_ids:[" . $userId. "]})" : '') . "  edges{ node { id, title } } } } } } }\"
		}");

		$response = curl_exec($this->curl);
		$pipesArray = json_decode($response);

		return $pipesArray->data->organization->pipes;
	}
}
