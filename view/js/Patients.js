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
            
            $('#patient-phone').mask('+7-(000)-000-00-00')
            
            loadPatients(1)
        });

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

function seePatient(id_patient)
{
	window.location.href = "index.php?controller=Histories&action=LoadSpecificHistory&patient="+id_patient;
}

function loadPatients(page)
{
	var search = $("#patientSearch").val()
	
	var firstChar = search.charAt(0)
	
	if( firstChar <='9' && firstChar >='0') {
      
		search = formatNumber(search)
	}
	
	$.ajax({
	    url: 'index.php?controller=Patients&action=GetPatients',
	    type: 'POST',
	    data: {
	    	search:search,
	    	page:page
	    },
	})
	.done(function(x) {
		x=x.trim()
		$('#patients_table').html(x)	
	})
	.fail(function() {
	    console.log("error");
	});
}

function savePatient()
{
 var name = $("#patient-name").val()
 var surname = $("#patient-surname").val()
 var patronimic = $("#patient-patronimic").val()
 var birthday = $("#patient-birthday").val()
 var phone = $("#patient-phone").val()
 var observation = $("#patient-observation").val()

 console.log(phone)
 
 if(name=="" || surname=="" || patronimic=="" ||
		 birthday=="" || phone=="")
	 {
		 alertMessages('warning','???????????????????? ?????????????????? ?????? ????????????!','????????????????')
	 }
 else
	 {
	 $.ajax({
		    url: 'index.php?controller=Patients&action=InsertPatient',
		    type: 'POST',
		    data: {
		    	patient_name:name,
		    	patient_surname:surname,
		    	patient_patronimic:patronimic,
		    	patient_birthday:birthday,
				patient_phone:phone,
				patient_observation:observation
		    },
		})
		.done(function(x) {
			x=x.trim()
			console.log("respuesta del servidor -> " +x)
			if(x=="2")
				{
				alertMessages('warning','?????????????? ?????? ??????????????????????????????!','????????????????')
				
				}
			else if (x=="1")
				{
				alertMessages('success','?????????????? ?????????????????????????????? ??????????????','????????????')
				clearFields()
				loadPatients(1)
				}
			else
				{
				alertMessages('error','?????????????????? ????????????:'+x,'????????????')
				}
			
			
		})
		.fail(function() {
		    console.log("error");
		});
	 }
  
}

function editPatient(id_patient)
{
	
	

	var set_fields = '<label class="control-label">??????????????:</label>'+
					'<input type="text" class="form-control" id="patient_new_surname" value=""  placeholder="??????????????">'+
					'<label class="control-label">??????:</label>'+
					'<input type="text" class="form-control" id="patient_new_name" value=""  placeholder="??????">'+
					'<label class="control-label">????????????????:</label>'+
					'<input type="text" class="form-control" id="patient_new_patronimic" value=""  placeholder="????????????????">'+
					'<label class="control-label">???????? ????????????????:</label>'+
					'<input class="form-control" type="date" value="" id="patient_new_birthday">'+	
					'<label for="cedula_usuarios" class="control-label">?????????? ????????????????:</label>'+
					'<input type="text" class="form-control" id="patient_new_phone" value=""  placeholder="??????????????">'+	
					'<label class="control-label">???????????????????? :</label>'+
					'<textarea  type="text" class="form-control" rows="3" maxlength="255" id="patient_new_observation" value=""  placeholder="????????????????????"></textarea>'
		
	var buttons = '<button type="button" class="btn btn-primary" onclick="updatePatient('+id_patient+')">??????????????????</button>'+
					'<button type="button" class="btn btn-danger" onclick="cancelModal()">????????????????</button>'
	
	$("#settings_modal").html(set_fields)
	$("#settings_footer").html(buttons)
	$('#patient_new_phone').mask('+7-(000)-000-00-00')
	
	$.ajax({
		    url: 'index.php?controller=Patients&action=getPatientInfo',
		    type: 'POST',
		    data: {
		    	patient_id:id_patient
		    },
		})
		.done(function(x) {
			x=JSON.parse(x)
			
			$("#patient_new_name").val(x[0]['imya_pacientes'])
			$("#patient_new_surname").val(x[0]['familia_pacientes'])
			$("#patient_new_patronimic").val(x[0]['ochestvo_pacientes'])
			$("#patient_new_birthday").val(x[0]['fecha_n_pacientes'])
			$("#patient_new_phone").val(x[0]['telefon_pacientes'])
			$("#patient_new_observation").val(x[0]['observacion_pacientes'])
			
			$("#patient_settings").modal('show')
		})
		.fail(function() {
		    console.log("error");
		});
	
	
}

function cancelModal()
{
	 $("#patient_settings").modal('hide')
}

function clearFields()
{
	$("#patient-name").val("")
	$("#patient-surname").val("")
	$("#patient-patronimic").val("")
	$("#patient-birthday").val("")
	$("#patient-phone").val("")
	$("#patient-observation").val("")
}

function cancelPatient()
{
	clearFields()
}

function changeTable()
{
	 var button_set = '<button type="button" class="btn btn-warning" onclick="editTable()"><i class="fa fa-pencil"></i></button>'
		 $("#edit_button").html(button_set)
		 loadPatients(1)
		 document.getElementById("patientSearch").onkeyup = function() {loadPatients(1)};
}

function editTable(page)
{
 var button_set = '<button type="button" class="btn btn-success" onclick="changeTable()"><i class="fa fa-check"></i></button>'
	 $("#edit_button").html(button_set)
	 var search = $("#patientSearch").val()
	 document.getElementById("patientSearch").onkeyup = function() {editTable(1)};
	 
	 var firstChar = search.charAt(0)
	
	if( firstChar <='9' && firstChar >='0') {
      
		search = formatNumber(search)
	}
	 
	 $.ajax({
		    url: 'index.php?controller=Patients&action=GetPatientsEditable',
		    type: 'POST',
		    data: {
				search:search,
				page:page
		    },
		})
		.done(function(x) {
			x=x.trim()
			$('#patients_table').html(x)	
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

function updatePatient(id_patient)
{
	var name = $("#patient_new_name").val()
 var surname = $("#patient_new_surname").val()
 var patronimic = $("#patient_new_patronimic").val()
 var birthday = $("#patient_new_birthday").val()
 var phone = $("#patient_new_phone").val()
 var observation = $("#patient_new_observation").val()
	
	if (name=="" || surname=="" || patronimic=="" ||
	birthday=="" || phone=="")
		{
	
		Swal.fire({
				  icon: 'warning',
				  title: '????????????????',
				  text: '???????????????????? ?????? ????????????'
				})
		}
	else
		{
		$.ajax({
			url: 'index.php?controller=Patients&action=UpdatePatient',
			type: 'POST',
			data: {
			patient_id:id_patient,
			patient_name:name,
		    	patient_surname:surname,
		    	patient_patronimic:patronimic,
		    	patient_birthday:birthday,
				patient_phone:phone,
				patient_observation:observation
			
			},
			})
			.done(function(x) {
			 if(x == 1)
				 {
				 Swal.fire({
					  icon: 'success',
					  title: '????????????',
					  text: '?????????????????? ??????????????????????'
					})
					editTable()
					cancelModal()
				 }
			 else if (x==0)
			 {
			  alertMessages('info','?????? ??????????????????','????????????????????')
			  cancelModal()
			 }
			 else
				 {
					Swal.fire({
						  icon: 'error',
						  title: '????????????',
						  text: '?????????????????? ???????????? :'+x
						})
				 }
			})
			.fail(function() {
			console.log("error");
			});
		}
	
}