var _token = $('input[name=_token]').val();

$(document).ready(function() {
    $(".calendar").each(function(){
        var userId = $(this).data('userid');
        var route = $(this).data('route');

        $(this).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            loading: function(bool) {
                if (bool){
                    $('.calendar_' + userId + ' .load-calendario').fadeIn();
                }else{
                    $('.calendar_' + userId + ' .load-calendario').fadeOut();
                }
            },
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

function calculaDias(date1){
    var data1 = moment(date1,'YYYY/MM/DD');
    var data2 = moment(getToday(),'YYYY/MM/DD');
    var diff  = data2.diff(data1, 'days');
    
    return ((diff <= 0) ? false : diff);
}

function getToday(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 

    today = yyyy+'-'+mm+'-'+dd;

    return today;
}