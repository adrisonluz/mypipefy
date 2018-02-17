<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\PipeConfig;
use App\Filters;

class ApiPipefy extends Model
{
	public $key = '';
	public $myId = null;
	protected $organizationID = null;
	protected $pipeIds = [];

	private $curl;

	public function __construct()
	{
		$this->organizationID = Config::get('app.PIPEFY_ORGANIZATION_ID','');
		$this->pipeIds = [];

		$this->curl = curl_init();
	}

	public function __destruct()
	{
		curl_close($this->curl);
	}

	public function me()
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ me { id, name, username, avatar_url, email, locale, time_zone } }\"
		}");

		$responseArray = $this->runCurl();

		return $responseArray->data->me;
	}

	public function getUsers()
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id:".$this->organizationID."){ id, members { user { id, name, email, username, avatarUrl } } } }\"
		}");

		$responseArray = $this->runCurl();
		return $responseArray->data->organization->members;
	}

	public function myCards()
	{
		return $this->userCards($this->myId);
	}

	public function userCards($userId = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ pipes { id, name, phases { id, name, cards( search:{assignee_ids:[" . $userId. "]}) {  edges{ node { url, id, title, due_date, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");

		$pipesArray = $this->runCurl();
		$myPipes = [];
		if (!is_null($pipesArray)) {
			foreach ($pipesArray->data->organization->pipes as $pipe) {
				$insert = false;
				$myCards = [];
				if (count($pipe->phases) > 0) {
					foreach ($pipe->phases as $phase) {
						$color = PipeConfig::getPhaseColor($phase->id);
						if ($color !== false) {
							if (count($phase->cards->edges) > 0) {
								$insert = true;
								foreach ($phase->cards as $card) {
									foreach ($card as $node) {
										$node->node->phaseName = $phase->name;
										$node->node->phaseId = $phase->id;
										$node->node->color = $color;
										$myCards[] = $node->node;
									}
								}
							}
						}
					}
				}

				if ($insert) {
					$myPipes[] = [
						'pipeId' => $pipe->id,
						'pipeName' => $pipe->name,
						'pipeCards' => $myCards
					];
				}
			}
		}
		return $myPipes;
	}

	public function onlyPipes($userId = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){  pipes { name id phases { id name } } } }\"
		}");

		$pipesArray = $this->runCurl();

		return $pipesArray->data->organization->pipes;
	}

	public function cardDetail($cardId = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
  \"query\": \"{ card(id: ".$cardId.") { title assignees { id } comments { text author { id } created_at } current_phase { name } done due_date fields { name value } phases_history { phase { name } firstTimeIn } url } }\"
}");

		$card = $this->runCurl();

		return $card->data->card;
	}

	public function comment($cardId, $comment){
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"mutation { createComment(input: {card_id: ".$cardId." text: \\\"".$comment."\\\" }) { comment { text author { id } created_at } } }\"
		}");

		$comment = $this->runCurl();

		if ($comment->data) {
			return $comment->data->createComment->comment;
		}

		return false;

	}

	public function filterCards(Filters $filter)
	{
		$assignees = [];
		foreach ($filter->assignees as $assignee) {
			$assignees[] = $assignee->assignee_id;
		}

		$owners = [];
		foreach ($filter->owners as $owner) {
			$owners[] = $owner->owner_id;
		}

		$phases = [];
		foreach ($filter->phases as $phase) {
			$phases[] = $phase->phase_id;
		}

		$assignees = !empty($assignees) ? implode(', ', $assignees) : false;

		$search = false;
		if ($assignees) {
			$search = '( search:{assignee_ids:['.$assignees.']}) ';
		}

		$search = is_array($search) ? implode(' ', $search) : null;
		
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, "{
		  \"query\": \"{ organization(id: " . $this->organizationID . "){ pipes { id, name, phases { id, name, cards ".$search."{  edges{ node { createdBy{ id, name }, url, id, title, due_date, assignees{id, name, username, email }, fields{ name, value, phase_field { id } } } }  } } } } }\"
		}");

		$pipesArray = $this->runCurl();

		$myPipes = [];
		if (!is_null($pipesArray)) {
			foreach ($pipesArray->data->organization->pipes as $pipe) {
				$insert = false;
				$myCards = [];
				if (count($pipe->phases) > 0) {
					foreach ($pipe->phases as $phase) {
						$color = PipeConfig::getPhaseColor($phase->id);
						$color = (!$color) ? '#2579a9' : $color;
						if (!empty($phases) && in_array($phase->id, $phases)) {
							if (count($phase->cards->edges) > 0) {
								$insert = true;
								foreach ($phase->cards as $card) {
									foreach ($card as $node) {
										if (!empty($owners) && in_array($node->node->createdBy->id, $owners)) {
											$node->node->phaseName = $phase->name;
											$node->node->phaseId = $phase->id;
											$node->node->color = $color;
											$myCards[] = $node->node;
										}
									}
								}
							}
						}
					}
				}

				if ($insert) {
					$myPipes[] = [
						'pipeId' => $pipe->id,
						'pipeName' => $pipe->name,
						'pipeCards' => $myCards
					];
				}
			}
		}
		return $myPipes;
	}

	private function runCurl()
	{
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

	public function getMyId($token)
	{
		$this->key = $token;
		$me = $this->me();
		return $me->id;
	}
}
