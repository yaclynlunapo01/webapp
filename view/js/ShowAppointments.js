$(document).ready(function(){

//loadAppointmentsTable()
loadSearchTypes()

})

function loadAppointment(id_appointment)
{
    $.ajax({
        url: 'index.php?controller=ShowAppointments&action=getAppointmentById',
        type: 'POST',
        data: {
            id_cita:id_appointment
        },
    })
    .done(function(x) {

        $("#tabla_citas").html(x)
        
		})
		.fail(function() {
		    console.log("error");
		});
}

function loadSearchTypes()
{
	$.ajax({
		    url: 'index.php?controller=ShowAppointments&action=getAppointmentType',
		    type: 'POST',
		    data: {},
		})
		.done(function(x) {
			
			x=JSON.parse(x)
					
		    select = document.getElementById('type_search');

		for (var i = 0; i<x.length; i++){
            switch (x[i]['nombre_estados'])
            {
                case "ACTIVO":
                    x[i]['nombre_estados']="АКТИВНЫЕ"
                    break;
                case "CANCELADO":
                    x[i]['nombre_estados']="ОТМЕНЕНЫЕ"
                    break;
                case "PAGADO":
                    x[i]['nombre_estados']="ОПЛАЧЕНЫЕ"
                    break;

            }
		    var opt = document.createElement('option');
		    opt.value = x[i]['id_estados'];
		    opt.innerHTML = x[i]['nombre_estados'];
		    select.appendChild(opt);
		}
		})
		.fail(function() {
		    console.log("error");
		});
}

function loadAppointmentsTable()
{
    var search_date = $("#search_date").val()
    var search_type = $("#type_search").val()

    $.ajax({
        url: 'index.php?controller=ShowAppointments&action=loadAppointments',
        type: 'POST',
        data: {search_date:search_date,
              search_type:search_type
        },
    })
    .done(function(x) {
        $("#tabla_citas").html(x)
    })
    .fail(function() {
        console.log("error");
    });
}

function cancelAppointment(id_cita)
{
    Swal.fire({
        title: 'Отменение запись',
        text: "Вы дейсвительно хотите отменить данную запись?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Отменить'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'index.php?controller=ShowAppointments&action=CancelAppointment',
                type: 'POST',
                data: {id_cita:id_cita
                },
            })
            .done(function(x) {
                if (x==1)
                {
                    alertMessages('success','Запись отменена','Готово')
                    loadAppointmentsTable()
                }
                else
                {
                    alertMessages('error','Произошла ошибка: '+x,'Ошибка')
                }
            })
            .fail(function() {
                console.log("error");
            });
        }
      })
    
}

function payAppointment(id_cita)
{
    Swal.fire({
        title: 'Совершение запись',
        text: "Вы дейсвительно хотите совершить данную запись?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Да',
        cancelButtonText: 'Отменить'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'index.php?controller=ShowAppointments&action=payAppointment',
                type: 'POST',
                data: {id_cita:id_cita
                },
            })
            .done(function(x) {
                if (x==1)
                {
                    alertMessages('success','Запись совершена','Готово')
                    loadAppointmentsTable()
                }
                else
                {
                    alertMessages('error','Произошла ошибка: '+x,'Ошибка')
                }
            })
            .fail(function() {
                console.log("error");
            });
        }
      })
    
}

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
}