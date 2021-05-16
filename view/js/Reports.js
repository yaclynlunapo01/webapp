
$(document).ready(function () {
    load_years()
});


function load_years()
{
    $.ajax({
        url: 'index.php?controller=Reports&action=GetYears',
        type: 'POST',
        data: {},
    })
    .done(function(x) {
        
        x=JSON.parse(x)
        
        
       var select = document.getElementById('anio_reporte');
        var select_mes = document.getElementById('anio_mes_reporte')

    for (var i = 0; i<x.length; i++){
        var opt = document.createElement('option');
        opt.value = x[i]['anios'];
        opt.innerHTML = x[i]['anios'];
        
        select_mes.appendChild(opt);
    }
        
        for (var i = 0; i<x.length; i++){
            var opt = document.createElement('option');
            opt.value = x[i]['anios'];
            opt.innerHTML = x[i]['anios'];
            
            select.appendChild(opt);
        }
    })
    .fail(function() {
        console.log("error");
    });
}

function getMonths()
{
    var year = $('#anio_mes_reporte').val()

    if(year == "")
    {
        $('#mes_mes_reporte').html("")
    }
    else
    {
        var m_select =  '<br>'+
                    '<select id="mes_reporte"  class="form-control">'+
                    '<option value="" selected="selected">--Выбрать месяц отчета:--</option>'+		
                    '</select>'+
                    '<br>'+
                    '<div class="col text-center">'+
                        '<button type="button" class="btn btn-primary" onclick="getMonth()">Открыть</button>'+
                    '</div>'

    $('#mes_mes_reporte').html(m_select)

    $.ajax({
        url: 'index.php?controller=Reports&action=GetMonths',
        type: 'POST',
        data: {
            year:year
        },
    })
    .done(function(x) {
        console.log(x)
        x=JSON.parse(x)
        
        
       var select = document.getElementById('mes_reporte');
        
        for (var i = 0; i<x.length; i++){
            var opt = document.createElement('option');
            opt.value = x[i][1];
            opt.innerHTML = x[i][0];
            
            select.appendChild(opt);
        }
    })
    .fail(function() {
        console.log("error");
    });
    }
}

function getDay()
{
    var date = $("#report-day").val()
    window.open('index.php?controller=Reports&action=GetDay&date='+date,'_blank');
}

