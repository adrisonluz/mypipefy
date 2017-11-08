$(document).ready(function() {
    $(".calendar").each(function(){
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
            loading: function(loading) {
                if(loading){
                    $(this).siblings('.load-calendario').fadeIn();
                }else{
                    $(this).siblings('.load-calendario').fadeOut();
                }
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: route,
                    method: 'GET',
                    async: false,
                    dataType: 'json',
                    success: function(cards) {
                        callback(cards);
                    }
                });
            },
            eventRender: function(event, element) {
                $(element).tooltip({title: event.title});
            }
        });
    });
});