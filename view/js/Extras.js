$(document).ready(function () {
            $('.collapse')
                .on('shown.bs.collapse', function() {
                	console.log("collapse")
                    $(this)
                        .parent()
                        .find(".fa-caret-square-o-down")
                        .removeClass("fa-caret-square-o-down")
                        .addClass("fa-caret-square-o-up");
                })
                .on('hidden.bs.collapse', function() {
                    $(this)
                        .parent()
                        .find(".fa-caret-square-o-up")
                        .removeClass("fa-caret-square-o-up")
                        .addClass("fa-caret-square-o-down");
                });
            
            getProcedures()
			getProceduresTable()
			getProceduresType()
        });

function getProceduresType()
{
	$.ajax({
			url: 'index.php?controller=Procedures&action=GetProcedureType',
			type: 'POST',
			data: {},
		})
		.done(function(x) {
			
			x=JSON.parse(x)
						
			var select_search = document.getElementById('procedure_type_search')

		for (var i = 0; i<x.length; i++){
			var opt = document.createElement('option');
			opt.value = x[i]['id_tipo_procedimientos'];
			opt.innerHTML = x[i]['nombre_tipo_procedimientos'];
			
			select_search.appendChild(opt);
		}
			
		})
		.fail(function() {
			console.log("error");
		});
}

function getProceduresTable()
{
	var search = $("#search_procedure").val()
	var type = $("#procedure_type_search").val()
	
	$.ajax({
		url: 'index.php?controller=Procedures&action=GetProceduresTable',
		type: 'POST',
		data: {
			search:search,
			type:type
		},
	})
	.done(function(x) {
		x=x.trim()
		$('#procedures_table').html(x)	
	})
	.fail(function() {
		console.log("error");
	});
}


function changeTable()
{
	 var button_set = '<button type="button" class="btn btn-warning" onclick="editTable()"><i class="fa fa-pencil"></i></button>'
		 $("#edit_button").html(button_set)
		 getProceduresTable()
		 document.getElementById("search_procedure").onkeyup = function() {getProceduresTable()};
		 document.getElementById("procedure_type_search").onchange = function() {getProceduresTable()};
}

function editTable()
{
 var button_set = '<button type="button" class="btn btn-success" onclick="changeTable()"><i class="fa fa-check"></i></button>'
	 $("#edit_button").html(button_set)
	 var search = $("#search_procedure").val()
	 var type = $("#procedure_type_search").val()
	 document.getElementById("search_procedure").onkeyup = function() {editTable()};
	 document.getElementById("procedure_type_search").onchange = function() {editTable()};
	 
	 
	 $.ajax({
		    url: 'index.php?controller=Procedures&action=GetProceduresTableEditable',
		    type: 'POST',
		    data: {
		    	search:search,
		    	type:type
		    },
		})
		.done(function(x) {
			x=x.trim()
			$('#procedures_table').html(x)	
		})
		.fail(function() {
		    console.log("error");
		});
}

function EditProcedureWOE(id_procedure)
{
	
	var set_fields = '<label class="control-label">Название:</label>'+
						'<input type="text" class="form-control" id="procedure_new_name" placeholder="Название"/>'+
						'<label class="control-label">Стоимость:</label>'+
						'<input type="number" class="form-control" id="procedure_new_cost" placeholder="Стоитмость"/>'+
						'<label class="control-label">Продолжительность:</label>'+
						'<input type="number" class="form-control" id="procedure_new_duration" placeholder="Продолжительность"/>'
		
	var buttons = '<button type="button" class="btn btn-primary" onclick="updateProcedureWOE('+id_procedure+')">Сохранить</button>'+
					'<button type="button" class="btn btn-danger" onclick="cancelModal()">Отменить</button>'
	
	$("#settings_modal").html(set_fields)
	$("#settings_footer").html(buttons)
	
	$.ajax({
		    url: 'index.php?controller=Procedures&action=getProcedureInfoWOE',
		    type: 'POST',
		    data: {
		    	procedure_id:id_procedure
		    },
		})
		.done(function(x) {
			x=JSON.parse(x)
			
			$("#procedure_new_name").val(x[0]['nombre_procedimientos'])
			$("#procedure_new_cost").val(x[0]['precio_procedimientos'])
			$("#procedure_new_duration").val(x[0]['duracion_procedimientos'])
			$("#procedure_settings").modal('show')
		})
		.fail(function() {
		    console.log("error");
		});
	
	
}

function EditExtra(id_procedure)
{
	
	var set_fields = '<label class="control-label">Название:</label>'+
						'<input type="text" class="form-control" id="procedure_new_name" placeholder="Название"/>'+
						'<label class="control-label">Стоимость:</label>'+
						'<input type="number" class="form-control" id="procedure_new_cost" placeholder="Стоитмость"/>'+
						'<label class="control-label">Продолжительность:</label>'+
						'<input type="number" class="form-control" id="procedure_new_duration" placeholder="Продолжительность"/>'
		
	var buttons = '<button type="button" class="btn btn-primary" onclick="updateExtra('+id_procedure+')">Сохранить</button>'+
					'<button type="button" class="btn btn-danger" onclick="cancelModal()">Отменить</button>'
	
	$("#settings_modal").html(set_fields)
	$("#settings_footer").html(buttons)
	
	$.ajax({
		    url: 'index.php?controller=Procedures&action=getProcedureInfoExtra',
		    type: 'POST',
		    data: {
		    	procedure_id:id_procedure
		    },
		})
		.done(function(x) {
			x=JSON.parse(x)
			
			$("#procedure_new_name").val(x[0]['nombre_especificaciones_procedimientos'])
			$("#procedure_new_cost").val(x[0]['costo_especificaciones_procedimientos'])
			$("#procedure_new_duration").val(x[0]['duracion_especificaciones_procedimientos'])
			$("#procedure_settings").modal('show')
		})
		.fail(function() {
		    console.log("error");
		});
	
	
}

function EditProcedureWE(id_procedure)
{
	var set_fields = '<label class="control-label">Название:</label>'+
	'<input type="text" class="form-control" id="procedure_new_name" placeholder="Название"/>'

	var buttons = '<button type="button" class="btn btn-primary" onclick="updateProcedureWE('+id_procedure+')">Сохранить</button>'+
	'<button type="button" class="btn btn-danger" onclick="cancelModal()">Отменить</button>'
	
	$("#settings_modal").html(set_fields)
	$("#settings_footer").html(buttons)
	
	$.ajax({
	url: 'index.php?controller=Procedures&action=getProcedureInfoWE',
	type: 'POST',
	data: {
	procedure_id:id_procedure
	},
	})
	.done(function(x) {
	
	$("#procedure_new_name").val(x)
	$("#procedure_settings").modal('show')
	})
	.fail(function() {
	console.log("error");
	});
		
	
}

function updateProcedureWOE(id_procedure)
{
	var name = $("#procedure_new_name").val()
	var cost = $("#procedure_new_cost").val()
	var duration = $("#procedure_new_duration").val()
	
	if (name == "" || cost == "" || duration == "")
		{
	
		Swal.fire({
				  icon: 'warning',
				  title: 'Внимание',
				  text: 'Запольните все данные'
				})
		}
	else
		{
		$.ajax({
			url: 'index.php?controller=Procedures&action=UpdateProcedureWOE',
			type: 'POST',
			data: {
			procedure_id:id_procedure,
			procedure_name:name,
			procedure_cost:cost,
			procedure_duration:duration
			},
			})
			.done(function(x) {
			 if(x == 1)
				 {
				 Swal.fire({
					  icon: 'success',
					  title: 'Готово',
					  text: 'Изменения сохранились'
					})
					editTable()
					cancelModal()
				 }
			 else if (x==0)
			 {
			  alertMessages('info','Нет изменений','Информация')
			  cancelModal()
			 }
			 else
				 {
					Swal.fire({
						  icon: 'error',
						  title: 'Ощибка',
						  text: 'Произошла ошибка :'+x
						})
				 }
			})
			.fail(function() {
			console.log("error");
			});
		}
	
}

function updateExtra(id_procedure)
{
	var name = $("#procedure_new_name").val()
	var cost = $("#procedure_new_cost").val()
	var duration = $("#procedure_new_duration").val()
	
	if (name == "" || cost == "" || duration == "")
		{
	
		Swal.fire({
				  icon: 'warning',
				  title: 'Внимание',
				  text: 'Запольните все данные'
				})
		}
	else
		{
		$.ajax({
			url: 'index.php?controller=Procedures&action=UpdateProcedureExtra',
			type: 'POST',
			data: {
			procedure_id:id_procedure,
			procedure_name:name,
			procedure_cost:cost,
			procedure_duration:duration
			},
			})
			.done(function(x) {
			 if(x == 1)
				 {
				 Swal.fire({
					  icon: 'success',
					  title: 'Готово',
					  text: 'Изменения сохранились'
					})
					editTable()
					cancelModal()
				 }
			 else if (x==0)
			 {
			  alertMessages('info','Нет изменений','Информация')
			  cancelModal()
			 }
			 else
				 {
					Swal.fire({
						  icon: 'error',
						  title: 'Ощибка',
						  text: 'Произошла ошибка :'+x
						})
				 }
			})
			.fail(function() {
			console.log("error");
			});
		}
	
}

function updateProcedureWE(id_procedure)
{
	var name = $("#procedure_new_name").val()
	
	if (name == "")
		{
	
		Swal.fire({
				  icon: 'warning',
				  title: 'Внимание',
				  text: 'Запольните все данные'
				})
		}
	else
		{
		$.ajax({
			url: 'index.php?controller=Procedures&action=UpdateProcedureWE',
			type: 'POST',
			data: {
			procedure_id:id_procedure,
			procedure_name:name
			},
			})
			.done(function(x) {
			 if(x == 1)
				 {
				 Swal.fire({
					  icon: 'success',
					  title: 'Готово',
					  text: 'Изменения сохранились'
					})
					editTable()
					cancelModal()
					getProcedures()
				 }
			 else if (x==0)
				 {
				  alertMessages('info','Нет изменений','Информация')
				  cancelModal()
				 }
			 else
				 {
					Swal.fire({
						  icon: 'error',
						  title: 'Ощибка',
						  text: 'Произошла ошибка :'+x
						})
				 }
			})
			.fail(function() {
			console.log("error");
			});
		}
	
}

function DeleteProcedureWOE(id_procedure)
{
	Swal.fire({
		  title: 'Удаление процедуры',
		  text: "Вы дейсвительно хотите удалить данную процедуру?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Удалить',
		  cancelButtonText: 'Отменить'
		}).then((result) => {
		  if (result.value) {
			  $.ajax({
					url: 'index.php?controller=Procedures&action=DeleteProcedureWOE',
					type: 'POST',
					data: {
					procedure_id:id_procedure
					},
					})
					.done(function(x) {
					 if(x == 1)
						 {
						 Swal.fire({
							  icon: 'success',
							  title: 'Готово',
							  text: 'Изменения сохранились'
							})
							editTable()
							cancelModal()
						 }
					 else if (x==0)
						 {
						  alertMessages('info','Нет изменений','Информация')
						  cancelModal()
						 }
					 else
						 {
							Swal.fire({
								  icon: 'error',
								  title: 'Ощибка',
								  text: 'Произошла ошибка :'+x
								})
						 }
					})
					.fail(function() {
					console.log("error");
					});
		  }
		})
}

function DeleteExtra(id_procedure)
{
	Swal.fire({
		  title: 'Удаление процедуры',
		  text: "Вы дейсвительно хотите удалить данную процедуру?",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Удалить',
		  cancelButtonText: 'Отменить'
		}).then((result) => {
		  if (result.value) {
			  $.ajax({
					url: 'index.php?controller=Procedures&action=DeleteExtra',
					type: 'POST',
					data: {
					procedure_id:id_procedure
					},
					})
					.done(function(x) {
					 if(x == 1)
						 {
						 Swal.fire({
							  icon: 'success',
							  title: 'Готово',
							  text: 'Изменения сохранились'
							})
							editTable()
							cancelModal()
						 }
					 else if (x==0)
						 {
						  alertMessages('info','Нет изменений','Информация')
						  cancelModal()
						 }
					 else
						 {
							Swal.fire({
								  icon: 'error',
								  title: 'Ощибка',
								  text: 'Произошла ошибка :'+x
								})
						 }
					})
					.fail(function() {
					console.log("error");
					});
		  }
		})
}

function cancelModal()
{
	 $("#procedure_settings").modal('hide')
}

function saveProcedureExtra()
{
 var name = $("#extra_name").val()
 var cost = $("#extra_cost").val()
 var id_procedure = $("#procedure_id").val()
 var duration = $("#extra_duration").val()
 
 if(name=="" || cost=="" || id_procedure=="" || duration == "")
	 {
	 var message="Пожалуйста заполните все данные!"
		 
		 alertMessages('warning',message, 'Внимание')
	 }
 else
	 {
	 $.ajax({
		    url: 'index.php?controller=Extras&action=InsertProcedureExtra',
		    type: 'POST',
		    data: {
		    	extra_name:name,
		    	extra_cost:cost,
		    	procedure_id:id_procedure,
		    	extra_duration:duration
		    },
		})
		.done(function(x) {
			x=x.trim()
			console.log("respuesta del servidor -> " +x)
			if(x=="2")
				{
				var message="Дополнение уже зарегистрировано!"
					alertMessages('warning',message, 'Внимание')
				}
			else if (x=="1")
				{
				var message = "Дополнение зарегистрировано успешно!"
				alertMessages('success',message, 'Готово')
				clearFields()
				getProceduresTable()
				}
			else
				{
				var message="Произошла ошибка!"+x
					alertMessages('error',message, 'Ошибка')
				}
			
			
		})
		.fail(function() {
		    console.log("error");
		});
	 }
  
}

function getProcedures()
{
	 $.ajax({
		    url: 'index.php?controller=Extras&action=GetProcedures',
		    type: 'POST',
		    data: {},
		})
		.done(function(x) {
			
			x=JSON.parse(x)
					
		    select = document.getElementById('procedure_id');
			
			for (i = select.length - 1; i > 1; i--) {
				select.remove(i);
			}

		for (var i = 0; i<x.length; i++){
		    var opt = document.createElement('option');
		    opt.value = x[i]['id_procedimientos'];
		    opt.innerHTML = x[i]['nombre_procedimientos'];
		    select.appendChild(opt);
		}
		})
		.fail(function() {
		    console.log("error");
		});
}

function getProcedureInfo()
{
	var id_tipo_procedimiento = $('#procedure_id').val()
	
	if(id_tipo_procedimiento!="")
		{
		$.ajax({
		    url: 'index.php?controller=Extras&action=GetProcedureType',
		    type: 'POST',
		    data: {
		    	id_tipo_procedimiento:id_tipo_procedimiento
		    },
		})
		.done(function(x) {
			x=JSON.parse(x)
			
			 var input_type='<label  class="control-label">Вид дополнения:</label>'+
	     		'<input type="text" class="form-control" id="extra_type" value="'+x[0]['nombre_tipo_procedimientos']+'"  readonly>'
	     		
     		var input_name='<label  class="control-label">Название дополнения:</label>'+
     		'<input type="text" class="form-control" id="extra_name" value=""  placeholder="Название">'

     		var input_cost='<label  class="control-label">Стоимость дополнения:</label>'+
     		'<input type="number" class="form-control" id="extra_cost" value=""  placeholder="Стоитмость">'
     		
     		var input_duration = '<label  class="control-label">Продолжительность дополнения:</label>'+
     		'<input type="number" class="form-control" id="extra_duration" value=""  placeholder="Продолжительность">'
     		
     		$('#procedure_type_info').html(input_type)
     		$('#procedure_extra_name').html(input_name)
     		$('#procedure_extra_cost').html(input_cost)
     		$('#procedure_extra_duration').html(input_duration)
		    
		
		})
		.fail(function() {
		    console.log("error");
		});
		}
	else
		{
			$('#procedure_type_info').html("")			
     		$('#procedure_extra_name').html("")
     		$('#procedure_extra_cost').html("")
     		$('#procedure_extra_duration').html("")
		}
		
}

function clearFields()
{
	$('#procedure_type_info').html("")
	$('#procedure_extra_name').html("")
	$('#procedure_extra_cost').html("")
	$('#procedure_extra_duration').html("")
	$("#procedure_id").val("")
}

function cancelExtra()
{
	clearFields()
}

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
}