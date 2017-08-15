var _token = $('input[name=_token]').val();

$(document).ready(function() {
    $(".calendar").each(function(){
        var userId = $(this).data('userid');
        var route = $(this).data('route');

        $(this).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            locale: 'pt-br',
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: route,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: _token,
                        userId: userId,
                        start: start.unix(),
                        end: end.unix()
                    },
                    success: function(result) {
                        var events = [];
                        $(result).each(function(key_card, card) {
                            var diff_days = calculaDias(card.start);
                            var color = '';

                            if(card.phaseName.toUpperCase() !== 'PENDENTE'){
                                switch(diff_days){
                                    case false:
                                        color = '#5cb85c';
                                        break;
                                    case 1:
                                        color = '#f0ad4e';
                                        break;
                                    default:
                                        color = '#d9534f';
                                }
                            }else{
                                color = '#292b2c ';
                            }
                                
                            events.push({
                                title: card.title,
                                start: card.start,
                                color: color,
                                url: 'https://app.pipefy.com/pipes/' + card.pipeId + '#cards/' + card.cardId,
                            });
                        });
                        callback(events);
                    }
                });
            },
            eventRender: function(event, element) {
                $(element).tooltip({title: event.title});
            }
        });
    });
});