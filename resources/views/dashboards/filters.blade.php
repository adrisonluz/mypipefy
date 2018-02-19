@extends('layouts.app')

@push('styles')
<link rel='stylesheet' href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/datatables.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/dataTables.bootstrap.min.css') }}" />
<link rel='stylesheet' href="{{ asset('plugins/datatables/css/responsive.bootstrap.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" />
@endpush

@push('scripts')
<script src="{{ asset('plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/locale/pt-br.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/sorting-uk.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.js"></script>
<script>
    $('#filter').on('change', function(){
        loadGrid($(this).val());
    });

    var collumns = [];
    function loadGrid(filter_id){
        $table = $(".table-filters");
        $('.loader-tables').fadeIn();
        $('.calendar').siblings('.load-calendario').fadeIn();
        var events = [];
        setTimeout(function(){
            $.ajax({
                url: '{{ route('api.get_cards_filter') }}/'+filter_id,
                dataType: 'json',
                async: false,
                success: function(data){
                    $table.DataTable().destroy();
                    $table.find('tbody, thead').html('');
                    var $th = '<tr>';
                    $.each(data.fields, function(field, label){
                        $th += '<th>'+label+'</th>';

                        collumns.push((field == 'due') ? { type: 'date-uk' } : null);
                    });
                    collumns.push({ orderable: false });
                    
                    $th += '<th>Ações</th>';
                    $th += '</tr>';
                    $table.children('thead').html($th);
                    
                    $.each(data.cards, function(index, card){
                        var $tr = '<tr data-toggle="tooltip" data-placement="left" title="'+card.phase+'">';
                        $.each(data.fields, function(field, label){
                            if (field == 'title') {
                                $tr += '<td><a href="'+card.url+'" target="_blank">'+card.title+'</a></td>';
                            } else if (field == 'pipe') {
                                $tr += '<td><a href="'+card.pipe_url+'" target="_blank">'+card.pipe+'</a></td>';
                            } else {
                                $tr += '<td>'+card[field]+'</td>';
                            }
                        });

                        events.push({
                            title: card.title,
                            color: card.color,
                            start: card.due_calendar,
                            url: card.url
                        });
                        $tr += '<td><button class="btn btn-primary" id="open-card" data-card="'+card.card_id+'">Ver Card</button></td>';
                        $tr += '</tr>';
                        $table.children('tbody').append($tr);
                    });

                    $('.calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,basicWeek,basicDay'
                        },
                        locale: 'pt-br',
                        eventClick: function(event) {
                            if (event.url) {
                                window.open(event.url, '_blank');
                                return false;
                            }
                        },
                        loading: function(loading) {
                            if (loading) {
                                $('.calendar').siblings('.load-calendario').fadeIn();
                                $('.loader-tables').fadeIn();
                            } else {
                                $('.loader-tables').fadeOut();
                                $('.calendar').siblings('.load-calendario').fadeOut();
                            }
                        },
                        events: events,
                        eventRender: function(event, element) {
                            $(element).tooltip({title: event.title});
                        }
                    });
                },
                complete: function(){
                    $('.loader-tables').fadeOut();
                    $('.calendar').siblings('.load-calendario').fadeOut();

                    $table.DataTable({
                        language: {
                            url: $("base").attr('href')+'plugins/datatables/languages/Portuguese-Brasil.json'
                        },
                        columns: collumns
                    });

                    $('#open-card[data-card]').on('click', function(){
                        $('body').addClass('modal-active');
                        getCardDetail($(this).data('card'));
                    });
                }
            });
        }, 1000);
    }

    @if ($filters->count() > 0)
    loadGrid({{ $filters[0]->id }});
    @endif

    $(".change-calendar-filters").on("click", function(event){
        event.preventDefault();
        const $icon = $(this).find("i.fa");

        //expandir
        if ($icon.hasClass("fa-expand")) {
            $icon.removeClass("fa-expand").addClass("fa-compress");
            $icon.parents(".div-calendar").removeClass("col-md-2").addClass("col-md-4");
            $icon.parents(".rowUserTeam").find(".col-md-10").removeClass("col-md-10").addClass("col-md-8");
            $icon.parents(".div-calendar").find(".fc-month-button").click();
        } else if ($icon.hasClass("fa-compress")) { //comprimir
            $icon.removeClass("fa-compress").addClass("fa-expand");
            $icon.parents(".div-calendar").removeClass("col-md-4").addClass("col-md-2");
            $icon.parents(".rowUserTeam").find(".col-md-8").removeClass("col-md-8").addClass("col-md-10");
            $icon.parents(".div-calendar").find(".fc-basicDay-button").click();
        }
        $table.DataTable().destroy();
        $table.DataTable({
            language: {
                url: $("base").attr('href')+'plugins/datatables/languages/Portuguese-Brasil.json'
            },
            columns: collumns
        });
        $(".calendar").fullCalendar('refetchEvents');
        
        $('#open-card[data-card]').on('click', function(){
            $('body').addClass('modal-active');
            getCardDetail($(this).data('card'));
        });
    });
</script>
@endpush

@section('content')
<div class="container">
    <div class="row">
        {{ csrf_field() }}

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="form-group">
                    <label for="filter">Escolha seu filtro</label>
                    <select name="filter" id="filter" class="form-control">
                        @forelse ($filters as $filter)
                        <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                        @empty
                        <option disabled selected>Você não possui filtros configurados</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="panel-body">
                <div class="row rowUserTeam">
                    <div class="col-md-8">
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
                        <table class="table display responsive no-wrap table-striped table-bordered table-filters">
                            <thead class="thead-inverse">
                                <tr>
                                  <td>Título</td>
                                  <td>Pipe</td>
                                  <td>Cliente</td>
                                  <td>DUE</td>
                                  <td>Ações</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <button type="button" name="button" class="buttonUpdateTable btn btn-primary"><i class="fa fa-refresh"></i> Atualizar cards</button>
                    </div>
                    <div class="col-md-4 div-calendar">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>
                                    <strong><i class="fa fa-calendar"></i> Tarefas Agendadas</strong>
                                    <a href="#" class="change-calendar-filters" style="float: right;"><i class="fa fa-compress"></i></a>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="calendar"></div>
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
</div>
@endsection
