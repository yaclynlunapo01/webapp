$(document).ready(function () {
            $('.collapse')
                .on('shown.bs.collapse', function() {
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
            
            getProceduresType()
            getProceduresTable()
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
						
			
		   var select = document.getElementById('procedure_type');
			var select_search = document.getElementById('procedure_type_search')

		for (var i = 0; i<x.length; i++){
		    var opt = document.createElement('option');
		    opt.value = x[i]['id_tipo_procedimientos'];
		    opt.innerHTML = x[i]['nombre_tipo_procedimientos'];
		    
		    select_search.appendChild(opt);
		}
			
			for (var i = 0; i<x.length; i++){
			    var opt = document.createElement('option');
			    opt.value = x[i]['id_tipo_procedimientos'];
			    opt.innerHTML = x[i]['nombre_tipo_procedimientos'];
			    
			    select.appendChild(opt);
			}
		})
		.fail(function() {
		    console.log("error");
		});
}

function setProcedureSettings()
{
	var type = $("#procedure_type").val()
	 
	if (type != "3" && type != "5" && type != "")
		{
		var input = '<label for="procedure_name" class="control-label">Название продцедуры:</label>'+
					'<input type="text" class="form-control" id="procedure_name" value=""  placeholder="Название">'
		
		$("#procedure_name_div").html(input)
		$("#procedure_cost_div").html("")
		$("#procedure_duration_div").html("")
		
        
        
		}
	else if (type == "")
		{
		$("#procedure_name_div").html("")
		$("#procedure_cost_div").html("")
		$("#procedure_duration_div").html("")
		}
	else
		{
		
		var input1 = '<label for="procedure_name" class="control-label">Название продцедуры:</label>'+
		'<input type="text" class="form-control" id="procedure_name" value=""  placeholder="Название">'
		
		var input2 = '<label for="procedure_cost" class="control-label">Стоимость процедуры:</label>'+
		'<input type="number" class="form-control" id="procedure_cost" value=""  placeholder="Стоитмость">'
		
		var input3 = '<label for="procedure_duration" class="control-label">Продолжительность процедуры:</label>'+
		'<input type="number" class="form-control" id="procedure_duration" value=""  placeholder="Продолжительность">'
		
		$("#procedure_name_div").html(input1)
		$("#procedure_cost_div").html(input2)
		$("#procedure_duration_div").html(input3)
		}
}

function saveProcedure()
{
 var name = $("#procedure_name").val()
 var cost = $("#procedure_cost").val()
 console.log(cost)
 var type = $("#procedure_type").val()
 var duration = $("#procedure_duration").val()
 
 if (typeof cost === 'undefined') cost = "0"
 if (typeof duration === 'undefined') duration = "0"
 
 console.log(cost)
 console.log(duration)
 console.log(name)
 console.log(type)
 
 if(name=="" || cost=="" || type=="" || duration == "")
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
		    url: 'index.php?controller=Procedures&action=InsertProcedure',
		    type: 'POST',
		    data: {
		    	procedure_name:name,
		    	procedure_cost:cost,
		    	procedure_type_id:type,
		    	procedure_duration:duration
		    },
		})
		.done(function(x) {
			x=x.trim()
			console.log("respuesta del servidor -> " +x)
			if(x=="2")
				{
				Swal.fire({
					  icon: 'warning',
					  title: 'Внимание',
					  text: 'Процедура уже зарегистрирована!'
					})
				}
			else if (x=="1")
				{
				alertMessages('success', 'Процедура довабилась успешно!', 'Готово')
				clearFields()
				getProceduresTable()
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

function clearFields()
{
	$("#procedure_name").val("")
	$("#procedure_cost").val("")
	$("#procedure_type").val("")
}

function cancelProcedure()
{
	clearFields()
	closeAlertProcedures()
}

function closeAlertProcedures()
{
	$("#alert-procedures").slideUp(500)	
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

function cancelModal()
{
	 $("#procedure_settings").modal('hide')
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

function alertMessages(tipo, mensaje, titulo)
{
	Swal.fire({
		  icon: tipo,
		  title: titulo,
		  text: mensaje
		})
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
					 if(x >= 1)
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