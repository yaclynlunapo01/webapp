$(document).ready(function(){

    
})

function formatNumber(number)
{
	var format = "+7-(XXX)-XXX-XX-XX"
	var res	
		for(var i = 0; i<number.length; i++)
			{
			 res=format.replace(/X/, number.charAt(i))
			 format = res
			}
	var x = format.indexOf("X")
	if (x==-1) x=format.length
	var newFormat = ""
	for (var i = 0; i<x; i++)
		{
		 newFormat += format.charAt(i)
		 
		}
	return newFormat
}

function showHistory(id_patient)
{
	$("#search_patient").val("")
	$.ajax({
	    url: 'index.php?controller=Histories&action=loadPatientHistory',
	    type: 'POST',
	    data: {
	    	patient_id:id_patient
	    },
	})
	.done(function(x) {
		x=JSON.parse(x)
		$('#info_patient_story').html(x[0])
		$('#tabla_pacientes').html(x[1])	
	})
	.fail(function() {
	    console.log("error");
	});
}

function loadPatients()
{
	var search = $("#search_patient").val()
	$("#info_patient_story").html("")
	
	var firstChar = search.charAt(0)
	
	if( firstChar <='9' && firstChar >='0') {
      
		search = formatNumber(search)
	}
	
	$.ajax({
	    url: 'index.php?controller=Histories&action=loadPatients',
	    type: 'POST',
	    data: {
	    	search:search
	    },
	})
	.done(function(x) {
		x=x.trim()
		$('#tabla_pacientes').html(x)	
	})
	.fail(function() {
	    console.log("error");
	});
}

function cancelAppointment(id_cita, id_paciente)
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
                    showHistory(id_paciente)
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

function payAppointment(id_cita, id_paciente)
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
                    showHistory(id_paciente)
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