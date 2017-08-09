var _token = $('input[name=_token]').val();

$(document).ready(function() {
    $(".calendar").each(function(){
        var userId = $(this).data('userid');
        var route = $(this).data('route');

        $(this).fullCalendar({
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

                            if(diff_days <= 0)
                                color = '#5cb85c'
                                
                            if(diff_days == 1)
                                color = '#f0ad4e'
                                
                            if(diff_days >= 2)
                                color = '#d9534f'
                                
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
        var data2 = moment('2017-08-09','YYYY/MM/DD');
        var diff  = data2.diff(data1, 'days');
        
        return diff;
}