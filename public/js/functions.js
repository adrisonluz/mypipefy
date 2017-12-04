$(document).ready(function() {
    $('a.show-comments').on('click', function(){
        if($(this).text() == 'Ver Comentários'){
            $(this).text('Ocultar Comentários');
            $('.show-timeline').text('Ver Timeline');
            $('#descricao-bloco, .timeline-row').slideUp('slow');
            $('.comments, .input-comment').slideDown('slow');
        }else{
            $(this).text('Ver Comentários');
            $('#descricao-bloco').slideDown('slow');
            $('.comments, .input-comment').slideUp('slow');
        }
    });

    $('a.show-timeline').on('click', function(){
        if($(this).text() == 'Ver Timeline'){
            $(this).text('Ocultar Timeline');
            $('.show-comments').text('Ver Comentários');
            $('.comments, #descricao-bloco, .input-comment').slideUp('slow');
            $('.timeline-row').slideDown('slow');
        }else{
            $(this).text('Ver Timeline');
            $('.timeline-row').slideUp('slow');
            $('#descricao-bloco').slideDown('slow');
        }
    });
    updateTables();
});

$('.mobile-menu-perfil').on('click', function(){
    $('body').toggleClass('menu-perfil-active');
});

$(window).scroll(function(){
    if($(this).scrollTop() >= 514){
        $('body').addClass('scrolled');
    }else{
        $('body').removeClass('scrolled');
    }
});

$('.click-to-top').on('click', function(){
    $('html,body').animate({ scrollTop:0 }, 800);
});

$(".invites").on('click', function(event) {
    event.stopPropagation();
});

$(".invites .buttons > div").on('click', function(event){
    event.preventDefault();
    var teamId = $(this).parent().data('teamid');
    var route = $(this).parent().data('route');
    var _token = $('input[name=_token]').val();

    var $item = $(this).parent().parent();

    if($(this).hasClass('accept')){
        var status = 2;
    }else if($(this).hasClass('decline')){
        var status = 0;
    }

    $.ajax({
        url: route,
        type: 'POST',
        dataType: 'json',
        data: {
            teamId: teamId,
            status: status,
            _token: _token
        },
        success: function(result){
            if(result.success){
                $item.html((status == 2) ? 'Agora este usuário já pode visualiar os seus cards!' : 'Este usuário não poderá ver os seus cards!');
            }else{
                alert('Ocorreu um erro inesperado');
            }
        },
        error: function(){
            alert('Ocorreu um erro inesperado');
        }
    });
});

$('.buttonUpdateTable').on('click', function(){
    var $button = $(this);
    //Atualiza o calendário
    if ($button.parent().parent().find('.calendar').length > 0) {
        $button.parent().parent().find('.calendar').fullCalendar('refetchEvents');
    }

    //Atualiza a tabela
    $button.siblings('.loader-tables').fadeIn();
    setTimeout(function(){
        updateTables($button.siblings('.dataTables_wrapper').find('.tableDashboard'));
        $button.siblings('.loader-tables').fadeOut();
    }, 1000);
});

$(window).on('load', function(){
    var alturaWindow  = window.innerHeight;
    var larguraWindow = window.innerWidth,
    alturaApp         = $('div#app').height() + 50;
    var urlHer        = location.pathname;

    if(urlHer != '/mypipefy/public/login'){
        if(alturaApp < alturaWindow){
            if(alturaWindow >= 635 && larguraWindow >= 1000){
                var alturaApp = $('div#app').height();
                alturaApp += 151;
                var margintContainer = alturaWindow - alturaApp
                $('div#app').css('margin-bottom', margintContainer+'px');
            }
        }
    }

    $('.loader').fadeOut('slow');
    $('.close-modal-info').on('click', function(){
        fechaModalDescripition();
    });

    $('.modal-info-table').on('lclick', function(e){
        if (e.target !== this) {
            return;
        }
        fechaModalDescripition();
    });

    function fechaModalDescripition(){
        if(!$('div#descricao-bloco').is(':visible')){
            $('.comments, .input-comment, .timeline-row').slideUp('slow');
            $('#descricao-bloco').slideDown('slow');
            $('a.show-comments').text('Ver Comentários');
            $('.show-timeline').text('Ver Timeline');
        }
        $('body').removeClass('modal-active');
        $('.modal-info-table').fadeOut('slow');
    }

    cheet('↑ ↑ ↓ ↓ ← → ← → b a', function () {
        var s = document.createElement('script');
        s.type='text/javascript';
        document.body.appendChild(s);
        s.src='http://www.apolinariopassos.com.br/asteroids.min.js';
    });

    cheet('p a h n a t e l a', function () {
        var s = document.createElement('script');
        s.type='text/javascript';
        document.body.appendChild(s);
        s.src='http://www.apolinariopassos.com.br/patos.js';
    });

    cheet('d e u d o w n a q u i', function () {
        var script = document.createElement('script');
        script.src='http://www.apolinariopassos.com.br/goograv.js';
        document.body.appendChild(script);
        javascript:scroll(0,0);
        document.body.style.overflow='hidden';
    });
});

function loaderPulse(){
    setInterval(function(){
        $('body').removeClass('rodando');
        setTimeout(function(){
            $('body').addClass('rodando');
        },100);
    },3000);
}

function updateTables($table){
    if ($table === undefined) {
        $('.tableDashboard').each(function(){
            $table = $(this);
            reloadtables($table);
        });
    } else {
        reloadtables($table);
    }
}

function reloadtables($table){
    $table.DataTable().destroy();
    $table.find('tbody').html('');
    var route = $table.data('route');
    $table.children('tbody').html('');

    $.ajax({
        url: route,
        type: 'GET',
        dataType: 'json',
        async: false,
        beforeSend: function(){
            $table.siblings('.loader-tables').fadeIn();
        },
        success: function(data){
            $("style.dashboardStyle").html(data.css);
            $.each(data.cards, function(index, card){
                var classColor = ' class="phase_'+card.phaseId+'"';
                var $tr = '<tr '+classColor+' data-toggle="tooltip" data-placement="left" title="'+card.phaseName+'">';
                if ($table.hasClass('table-general')){
                    $tr += '<td>'+card.assignee+'</td>';
                }
                $tr += '<td><a href="'+card.url+'" target="_blank">'+card.cardTitle+'</a></td>';
                $tr += '<td><a href="'+card.pipeUrl+'" target="_blank">'+card.pipeName+'</a></td>';
                $tr += '<td>'+card.clientName+'</td>';
                $tr += '<td>'+card.due+'</td>';
                $tr += '<td><button class="btn btn-primary" id="open-card" data-card="'+card.cardId+'">Ver Card</button></td>';
                $tr += '</tr>';
                $table.children('tbody').append($tr);
            });
        },
        complete: function(){
            $table.siblings('.loader-tables').fadeOut();
            var collumns = [
                null,
                null,
                null,
                { type: 'date-uk' },
                { orderable: false },
            ];

            if ($table.hasClass('table-general')){
                collumns.unshift(null);
            }

            var keyOrder = ($table.hasClass('table-general')) ? 4 : 3;

            $table.DataTable({
                order: [[keyOrder, 'asc']],
                language: {
                    url: $("base").attr('href')+'plugins/datatables/languages/Portuguese-Brasil.json'
                },
                columns: collumns
            });

            $('[data-toggle="tooltip"]').tooltip({
                placement: (window.innerWidth < 768) ? 'top' : 'right'
            });

            $('#open-card[data-card]').on('click', function(){
                $('body').addClass('modal-active');
                getCardDetail($(this).data('card'));
            });
        }
    });
}

function getCardDetail(cardId){
    if(cardId != ''){
        $.ajax({
            url: $("base").attr('href')+'api/card/detail/'+cardId,
            type: 'GET',
            dataType: 'json',
            success: function(card){
                $('.modal-info-table .title-info').text(card.title);
                $('.modal-info-table .due-card-here').text(card.due_date);
                $('.modal-info-table .description').html(card.description);
                $('.modal-info-table [name=card_id]').val(cardId);
                $('#siteUrl').attr('href', card.siteUrl);
                $('#cardUrl').attr('href', card.url);

                //Fields
                var fieldsHtml = '';
                $.each(card.fields, function(index, field){
                    fieldsHtml += '<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">'+
                    '<p class="start-from"><span>'+field.name+':</span> <strong>'+field.value+'</strong></p>'+
                    '</div>';
                });

                //Attachments
                var attachmentsHtmlImg = '';
                var attachmentsHtmlFile = '';
                $.each(card.attachments, function(index, attachment){
                    if(attachment.type == 'image'){
                        attachmentsHtmlImg += '<div class="col-md-3"><a data-fancybox="gallery" href="'+attachment.link+'"><img src="'+attachment.link+'" target="_blank" alt="'+attachment.name+'"/></a></div>';
                    }else{
                        attachmentsHtmlFile += '<div class="col-md-12"><a href="'+attachment.link+'">'+attachment.name+'</a></div>';
                    }
                });
                var attachmentsHtml = attachmentsHtmlImg+attachmentsHtmlFile;

                //Timeline
                var timelineHtml = '';
                $.each(card.phases_history, function(index, phase){
                    timelineHtml += (index % 2 == 0) ? '<li>' : '<li class="timeline-inverted">';
                    timelineHtml +=     '<div class="timeline-badge"><i class="fa fa-clock-o"></i></div>'+
                                        '<div class="timeline-panel">'+
                                            '<div class="timeline-heading">'+
                                                '<h4 class="timeline-title">'+phase.name+'</h4>'+
                                                '<p><small class="text-muted"><i class="fa fa-clock-o"></i> '+phase.date+'</small></p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</li>';
                });

                //Assignees
                var assigneesHtml = '';
                $.each(card.assignees, function(index, assignee){
                    assigneesHtml += '<img src="'+assignee.avatar+'" title="'+assignee.name+'" alt="'+assignee.name+'" class="img-responsive img-thumbnail">';
                });

                //Comments
                var commentsHtml = '';
                $.each(card.comments, function(index, comment){
                    commentsHtml += '<div>'+
                                        '<img src="'+comment.author.avatar+'" title="'+comment.author.name+'" alt="'+comment.author.name+'" class="img-responsive img-thumbnail">'+
                                        '<div><span>'+comment.author.name+'</span>'+
                                            '<p>'+comment.text+'</p>'+
                                            '<span class="date">'+comment.created_at+'</span>'+
                                        '</div>'+
                                    '</div>';
                });

                if(attachmentsHtml == ''){
                    $('#anexos-bloco').hide();
                }else {
                    $('.modal-info-table .attachments').html(attachmentsHtml);
                    $('#anexos-bloco').show();
                }

                $(".modal-info-table .fields").html(fieldsHtml);
                $(".modal-info-table .timeline").html(timelineHtml);
                $(".modal-info-table .assignees").html('<span class="title-row">Responsáveis:</span>'+assigneesHtml);

                if(commentsHtml == ''){
                    $('div#bloco-comentarios').hide();
                }else {
                    $('div#bloco-comentarios').show();
                    $(".modal-info-table .comments").html('<span class="title-row">Comentários:</span>'+commentsHtml);
                }

                $('.assignees img').tooltip();
                $('.modal-info-table').fadeIn('slow');
            }
        });
    }
}

$(".input-comment form").on('submit', function(event) {
    event.preventDefault();
    var action = $(this).attr('action');
    var data = $(this).serialize();
    $button = $(this).find('[type=submit]');
    $button.prop('disabled', true);

    $.ajax({
        url: action,
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function(response) {
            if (response.success) {
                var comment = response.comment;
                commentsHtml = '<div>'+
                                    '<img src="'+comment.author.avatar+'" title="'+comment.author.name+'" alt="'+comment.author.name+'" class="img-responsive img-thumbnail">'+
                                    '<div><span>'+comment.author.name+'</span>'+
                                        '<p>'+comment.text+'</p>'+
                                        '<span class="date">'+comment.created_at+'</span>'+
                                    '</div>'+
                                '</div>';
                if($('div#bloco-comentarios .comments').html() == ''){
                    $(".modal-info-table .comments").html('<span class="title-row">Comentários:</span>'+commentsHtml);
                    $('div#bloco-comentarios').show();
                }else {
                    $(".modal-info-table .comments").append(commentsHtml);
                }
                $(".input-comment form textarea").val('');
            }
        },
        complete: function() {
            $button.prop('disabled', false);
        }
    });
});
