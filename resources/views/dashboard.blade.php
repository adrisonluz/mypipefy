@extends('layouts.app')

@push('styles')
    <link rel='stylesheet' href="{{ asset('plugins/datatables/css/datatables.min.css') }}" />
    <link rel='stylesheet' href="{{ asset('plugins/datatables/css/dataTables.bootstrap.min.css') }}" />
    <link rel='stylesheet' href="{{ asset('plugins/datatables/css/responsive.bootstrap.min.css') }}" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
    <script src="{{ asset('plugins/fullcalendar/lib/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/js/responsive.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
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
                    <button type="button" name="button" class="buttonUpdateTable btn btn-primary">Atualizar</button>
                </div>

                <div class="col-md-4 div-calendar">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4><strong>Gráficos</strong></h4>
                        </div>
                        <div class="panel-body">
                            @if (count($allPipes->pipes) > 0)
                            @foreach($allPipes->pipes as $pipe)
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$pipe->id}}: {{$pipe->name}} <button class="btn btn-xs btn-primary pull-right" data-toggle="collapse" data-target="#{{$pipe->id}}">&#9660;</button></div>

                                <div id="{{$pipe->id}}" class="panel-body collapse">
                                    <div class="chart-container" style="position: relative;">
                                        <canvas id="chart_{{$pipe->id}}"></canvas>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
