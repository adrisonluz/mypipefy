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
            eventClick: function(event) {
                if (event.url) {
                    window.open(event.url, '_blank');
                    return false;
                }
            },
            loading: function(loading, $calendar) {
                if(loading){
                    $(this).siblings('.load-calendario').fadeIn();
                }else{
                    $(this).siblings('.load-calendario').fadeOut();
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
                                
                            events.push({
                                title: card.title,
                                start: card.start,
                                color: card.color,
                                url: card.url
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