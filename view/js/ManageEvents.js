$(document).ready(function(){

  GetUserName()
  getEventType()
  
  })

function GetUserName()
{
  $.ajax({
    url: 'index.php?controller=ConcertFeed&action=GetUserName',
    type: 'POST',
    data: {
    },
})
.done(function(x) {
  x=x.trim()
  console.log(x)
   $('#nombre_usuario_actual').html(x)  
})
.fail(function() {
    console.log("error");
});
}

function getEventType()
{
	 $.ajax({
		    url: 'index.php?controller=ManageEvents&action=GetEventType',
		    type: 'POST',
		    data: {},
		})
		.done(function(x) {
			x=JSON.parse(x)						
			
		   var select = document.getElementById('event_type');

		for (var i = 0; i<x.length; i++){
		    var opt = document.createElement('option');
		    opt.value = x[i]['id_tipo_evento'];
		    opt.innerHTML = x[i]['nombre_tipo_evento'];
		    
		    select.appendChild(opt);
		}
		})
		.fail(function() {
		    console.log("error");
		});
}

function validateEventData()
{
	var validate = true

	var name = $("#event_name").val()
	var type = $("#event_type").val()
	var date = $("#event_date").val()
	var time = $("#event_time").val()
	var description = $("#event_description").val()

	if (name == "")
	{
		validate = false
		alertMessages("warning", "Введите название!", "Внимание!")
		return validate
	}
	if (type == "")
	{
		validate = false
		alertMessages("warning", "Выберите вид мероприятия!", "Внимание!")
		return validate
	}
	if (date == "")
	{
		validate = false
		alertMessages("warning", "Введите дату!", "Внимание!")
		return validate
	}
	else
	{
		var today = new Date()
		var date_c = new Date (date)

		if (date_c <= today)
		{
			validate = false
			alertMessages("warning", "Выбрана не допустимая дата!", "Внимание!")
			return validate
		}
	}
	if (time == "")
	{
		validate = false
		alertMessages("warning", "Выберите время!", "Внимание!")
		return validate
	}
	if (description == "")
	{
		validate = false
		alertMessages("warning", "Введите описание!", "Внимание!")
		return validate
	}
	
		return validate
	
}

function saveEvent()
{
	if (validateEventData())
	{
		var name = $("#event_name").val()
		var type = $("#event_type").val()
		var date = $("#event_date").val()
		var time = $("#event_time").val()
		var description = $("#event_description").val()

		$.ajax({
			url: 'index.php?controller=ManageEvents&action=InsertEvent',
			type: 'POST',
			data: {        
			event_name: name,
			event_type: type,
			event_date: date,
			event_time: time,
			event_description: description
			},
		})
		.done(function(x) {
			x=x.trim()
			if (x=="0")
			{
				alertMessages("warning", "Дата уже занята", "Внимание!")
			}
			else if (x.includes("<b>Warning</b>"))
			{
				alertMessages("error", "Произошла ошибка: "+x, "Ошибка!")
			}
			else if (x=="1")
			{
				alertMessages("success", "Мероприятие зарегистрировано!", "Успех!")
				cancelarRegistro()
			}
			else
			{
				alertMessages("warning", x, "Внимание!")
			}
			
			
		})
		.fail(function() {
			console.log("error");
		});
	}
}

function cancelarRegistro()
{
	$("#event_name").val('')
	$("#event_type").val('')
	$("#event_date").val('')
	$("#event_time").val('')
	$("#event_description").val('')

}

function salirSesion()
{
  $.ajax({
    url: 'index.php?controller=AdminFeed&action=SalirSesion',
    type: 'POST',
    data: {
    },
})
.done(function(x) {

      window.location.href = "index.php?controller=UserLogin&action=index"
})
.fail(function() {
    console.log("error");
});

}

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
}