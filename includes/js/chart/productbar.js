function product_sale_chart(){
	//get canvas
    var product_bardata = {
        labels : productbycat_labels,
        datasets : [
            {
                data : productbycat_values,
                backgroundColor : "#8DC63F",
                borderWidth : 0
            }
        ]
    };
    var product_bar_options = {
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

    var ctx = $('#productbarChart');

    var chart = new Chart( ctx, {
        type : 'bar',
        data : product_bardata,
        options : product_bar_options
    })
}