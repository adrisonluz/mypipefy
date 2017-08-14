@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/r-2.1.1/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
    <link rel='stylesheet' href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.15/r-2.1.1/datatables.min.js"></script>
    <script src="{{ asset('plugins/fullcalendar/lib/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('js/team.js') }}"></script>
@endpush

@section('content')
<div class="container">
    <div class="row">
        {{ csrf_field() }}

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1>Dashboard Team</h1>
            </div>

            <div class="panel-body">
                @if(count($team) > 0)
                @foreach($team as $userId)
                <div class="row rowUserTeam">
                    <div class="col-xs-12">
                        <h3>{{$userId}}</h3>
                    </div>
                    <div class="col-md-8" data-userid="{{$userId}}">
                        <table class="table display responsive no-wrap table-striped table-bordered tableDashboard" data-route="{{ route('api.get_cards_user_id', ['userId' => $userId]) }}">
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
                        <div class="load-datatables">
                            <img src="{{asset('img/mypipefy.png')}}" title="Loading ..." class="animated infinite flip"/>
                            <p><strong>Carregando ...</strong></p>
                        </div>
                    </div>
                
                    <div class="col-md-4 div-calendar">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4><strong>Tarefas Agendadas</strong></h4>
                            </div>
                            <div class="panel-body">
                                <div class='calendar calendar_{{$userId}}' data-userid="{{$userId}}" data-route="{{route('api.get_cards_user')}}">
                                    <div class="load-calendario">
                                        <img src="{{asset('img/mypipefy.png')}}" title="Loading ..." class="animated infinite flip"/>
                                        <p><strong>Carregando ...</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
