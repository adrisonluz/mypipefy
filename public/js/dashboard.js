var _token = $('input[name=_token]').val();

$.post("api/onlyPipes", {_token: _token}, function(result){

    $.each(result, function(key_pipe, pipe){
        var phases_array = [];
        var phases_cards_count = [];

        $.each(pipe.phases, function(key_phase, phase){
            phases_cards_count.push((phase.cards.edges).length);
            phases_array.push(phase.name + ' (' + (phase.cards.edges).length + ')');
        });

        var ctx = document.getElementById("chart_" + pipe.id);
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: phases_array,
                datasets: [{
                    label: '# of Votes',
                    data: phases_cards_count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    }); 
});