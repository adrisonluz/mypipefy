<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ApiPipefy;
use App\PipefyUser;
use App\Filters;
use App\FilterAssignees;
use App\FilterOwners;
use App\FilterPhases;

class FiltersController extends Controller
{
    public function __construct(ApiPipefy $apiPipefy)
    {
        parent::__construct($apiPipefy);
        $this->apiPipefy = $apiPipefy;
    }

    public function filters()
    {
        $this->retorno['filters'] = Filters::all();

        return view('filters.index', $this->retorno);
    }

    public function insert()
    {
        self::pipefyAuth();
        $this->retorno['filter'] = new Filters;
        $this->retorno['owners'] = $this->retorno['assignees'] = PipefyUser::where('username', '<>', '')->orderBy('name', 'asc')->get();
        $this->retorno['pipes'] = $this->apiPipefy->onlyPipes();
        $this->retorno['assignees_selected'] = $this->retorno['owners_selected'] = $this->retorno['phases_selected'] = [];

        return view('filters.add', $this->retorno);
    }

    public function edit($filter_id)
    {
        self::pipefyAuth();
        $this->retorno['filter'] = Filters::find($filter_id);

        $this->retorno['assignees_selected'] = [];
        foreach ($this->retorno['filter']->assignees as $assignee) {
            $this->retorno['assignees_selected'][] = $assignee->assignee_id;
        }

        $this->retorno['owners_selected'] = [];
        foreach ($this->retorno['filter']->owners as $owner) {
            $this->retorno['owners_selected'][] = $owner->owner_id;
        }

        $this->retorno['phases_selected'] = [];
        foreach ($this->retorno['filter']->phases as $phase) {
            $this->retorno['phases_selected'][] = $phase->phase_id;
        }

        $this->retorno['owners'] = $this->retorno['assignees'] = PipefyUser::where('username', '<>', '')->orderBy('name', 'asc')->get();
        $this->retorno['pipes'] =$this->apiPipefy->onlyPipes();

        return view('filters.add', $this->retorno);
    }

    public function save(Request $request)
    {
        $filter = empty($request->id) ? new Filters : Filters::find($request->id);

        $filter->name = $request->name;

        $filter->save();

        $filter->assignees()->delete();
        foreach ($request->assignee_id as $assignee_id) {
            $filterAssignee = new FilterAssignees(['assignee_id' => $assignee_id]);

            $filter->assignees()->save($filterAssignee);
        }

        $filter->owners()->delete();
        foreach ($request->owner_id as $owner_id) {
            $filterOwners = new FilterOwners(['owner_id' => $owner_id]);

            $filter->owners()->save($filterOwners);
        }

        $filter->phases()->delete();
        foreach ($request->phase_id as $phase_id) {
            $filterPhases = new FilterPhases(['phase_id' => $phase_id]);

            $filter->phases()->save($filterPhases);
        }

        return redirect()->route('config.filters.edit', $filter->id)->with('status', 'Filtro salvo com sucesso!');

    }

    public function destroy($filter_id)
    {
        Filters::find($filter_id)->delete();
        return redirect()->route('config.filters')->with('status', 'Filtro deletado com sucesso!');
    }
}