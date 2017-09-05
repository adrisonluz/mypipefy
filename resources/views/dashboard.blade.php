@extends('layouts.app')

@push('styles')
<link rel='stylesheet' href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/datatables.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/dataTables.bootstrap.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/responsive.bootstrap.min.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/locale/pt-br.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/sorting-uk.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/team.js') }}"></script>
@endpush

@section('content')
<div class="container">
  <div class="row">
    {{ csrf_field() }}

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h1>Dashboard</h1>
      </div>

      <div class="panel-body">
        <div class="col-md-8 div-table">
          <div class="loader-tables" style="display:none;">
            <div class="load-pages">
              <div class="gif-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
          </div>
          <table class="table display responsive no-wrap table-striped table-bordered tableDashboard" data-route="{{ route('api.get_cards_user_id', ['userId' => $me->id]) }}">
            <thead class="thead-inverse">
              <tr>
                <td>ID</td>
                <td>Pipe</td>
                <td>Título</td>
                <td>Cliente</td>
                <td>DUE</td>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <button type="button" name="button" class="buttonUpdateTable btn btn-primary"><i class="fa fa-refresh"></i> Atualizar cards</button>
        </div>

        <div class="col-md-4 div-calendar">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h4><strong><i class="fa fa-calendar"></i> Tarefas Agendadas</strong></h4>
            </div>
            <div class="panel-body">
            <div class='calendar calendar_{{$me->id}}' data-userid="{{$me->id}}" data-route="{{route('api.get_cards_user')}}">
              </div>
              <div class="load-calendario" style="display:none;">
                <div class="load-pages">
                  <div class="gif-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
