function sales_chart(){
	//get canvas
    var sales_peruser_bardata = {
        labels : saler_peruser_labels,
        datasets : [
            {
                data : saler_peruser_values,
                backgroundColor : "#8DC63F",
                borderWidth : 0
            }
        ]
    };
    var sales_peruser_options = {
        title : {
            display : false,
            position : "top",
            text : "",
            fontSize : 18,
            fontColor : "#111"
        },
        legend : {
            display : false,
            position : "bottom"
        },
        scales : {
              yAxes : [{
                ticks : {
                  beginAtZero: true,
                },
                gridLines : {
                  borderDash: [0, 1],
                  color: "#9c9da0"
                }
                
              }],
              xAxes : [{
                 gridLines: {
                    display: false,
                    color: "#9c9da0"
                  },
                    categoryPercentage: 0.5,
                    barPercentage: 1
              }]
            }
    };

    var saleschart = $('#sales_per_user');

    var chart = new Chart( saleschart, {
        type : 'bar',
        data : sales_peruser_bardata,
        options : sales_peruser_options
    })
}