@extends('layouts.app')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
@endpush
<div class="container config">
    @if (session('status'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('status') }}
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h1>Incluír/alterar filtro</h1>
            </div>
            <div class="panel-body">
                <form action="{{ route('config.filters.save') }}" method="POST">
                    <div class="form-group">
                        <label for="name">Nome do Filtro</label>
                        <input type="text" name="name" value="{{ $filter->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="owner">Criadores do Card</label>
                        <select name="owner_id[]" multiple class="form-control selectpicker" data-live-search="true">
                            @foreach ($owners as $owner)
                            @if (in_array($owner->pipefy_id, $owners_selected))
                            <option selected value="{{ $owner->pipefy_id }}" data-subtext="{{ '@'.$owner->username }}">{{ $owner->name }}</option>
                            @else
                            <option value="{{ $owner->pipefy_id }}" data-subtext="{{ '@'.$owner->username }}">{{ $owner->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assignee">Responsáveis</label>
                        <select name="assignee_id[]" multiple class="form-control selectpicker" data-live-search="true">
                            @foreach ($assignees as $assignee)
                            @if (in_array($assignee->pipefy_id, $assignees_selected))
                            <option selected value="{{ $assignee->pipefy_id }}" data-subtext="{{ '@'.$assignee->username }}">{{ $assignee->name }}</option>
                            @else
                            <option value="{{ $assignee->pipefy_id }}" data-subtext="{{ '@'.$assignee->username }}">{{ $assignee->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assignee">Fases</label>
                        <select name="phase_id[]" multiple class="form-control selectpicker" data-live-search="true">
                            @foreach ($pipes as $pipe)
                            <optgroup label="{{ $pipe->name }}">
                                @foreach ($pipe->phases as $phase)
                                @if (in_array($phase->id, $phases_selected))
                                <option selected value="{{ $phase->id }}">{{  $phase->name }}</option>
                                @else
                                <option value="{{ $phase->id }}">{{  $phase->name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $filter->id }}">
                    <input type="submit" value="Salvar" class="btn btn-primary pull-right">
                    <a href="{{ route('config.filters') }}" class="btn btn-default pull-right" style="margin-right: 5px;">Voltar</a>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
