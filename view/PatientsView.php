<!doctype html>
<html lang="en">
  <?php include("view/universal/head.php")?>
  <body>
  	<!--Navigation  -->
  	
    <?php include("view/universal/navbar.php")?>
    
    <!-- Page tittle -->
	<div class="container-fluid sticky-top sticky-offset bg-light">
		<ul class="nav nav-tabs justify-content-center">
          <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Patients") echo "active"; else echo "text-muted"?>" href="index.php?controller=Patients&action=index"><h3>Пациенты</h3></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Histories") echo "active"; else echo "text-muted"?>" href="index.php?controller=Histories&action=index"><h3>Истории</h3></a>
          </li>
        </ul>
	</div>
	
	<!-- Tabla de citas -->
	
	<div class="wrapper">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h3 class="mb-0">
          	Регистрация
            <button class="btn float-right" data-toggle="collapse" data-target="#collapseRegistration" aria-expanded="false" aria-controls="collapseRegistration">
              <i class="fa fa-caret-square-o-up fa-lg"></i>
            </button>
          </h3>
        </div>
        
        
    
        <div id="collapseRegistration" class="collapse show" aria-labelledby="headingRegistration">
            <div id="alert-patients" class="alert alert-danger alert-dismissible fade show" style="display: none" role="alert">
              <div id="alert-message-patients"></div>
              <button type="button" class="close" aria-label="Close" onclick="closeAlertPatients()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <div class="card-body multi-collapse">
            <div class="row">
            	<div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label class="control-label">Фамилия:</label>
                        <input type="text" class="form-control" id="patient-surname" value=""  placeholder="Фамилия">
                     </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                 	<div class="form-group">
                    	<label class="control-label">Имя:</label>
                        <input type="text" class="form-control" id="patient-name" value=""  placeholder="Имя">
                     </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label class="control-label">Отчество:</label>
                        <input type="text" class="form-control" id="patient-patronimic" value=""  placeholder="Отчество">
                     </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label class="control-label">Дата рождения:</label>
                          <input class="form-control" type="date" value="" id="patient-birthday">
                     </div>
                 </div>
            </div>
            <div class="row">
            	<div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label for="cedula_usuarios" class="control-label">Номер телефона:</label>
                        <input type="text" class="form-control" id="patient-phone" value=""  placeholder="Телефон">
                     </div>
                 </div>
            </div>
            <div class="row">
            	<div class="col">
            		<label class="control-label">Примечания :</label>
                <textarea  type="text" class="form-control" rows="3" maxlength="255" id="patient-observation" value=""  placeholder="Примечания"></textarea>
            	</div>	
           	</div>
            <div class="row" style="padding-top: 1%;">
            	<div class="col text-center">
            		<button type="button" class="btn btn-primary" onclick="savePatient()">Сохранить</button>
            		<button type="button" class="btn btn-danger" onclick="cancelPatient()">Отменить</button>
            	</div>	
           	</div>
          </div>
        </div>
      </div>
     </div>
      <div class="wrapper">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h3 class="mb-0">
          	Пациенты
            <button class="btn float-right" data-toggle="collapse" data-target="#collapseTable" aria-expanded="false" aria-controls="collapseTable">
              <i class="fa fa-caret-square-o-up fa-lg"></i>
            </button>
          </h3>
        </div>
    
        <div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
          <div class="card-body multi-collapse">
            <div class="row">
            	<div class="col-xs-6 col-md-3 col-lg-3 ">
                <div id="edit_button">
                  <button type="button" class="btn btn-warning" onclick="editTable()"><i class="fa fa-pencil"></i></button>
                </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                        <input type="text" class="form-control" id="patientSearch" value="" onkeyup="loadPatients(1)"  placeholder="Пойск">
                     </div>
                 </div>
            </div>
            <div class="row">
            	<div class="col-xs-12 col-md-12 col-lg-12 ">
                	<div id="patients_table"></div>
                 </div>
            </div>
          </div>
        </div>
      </div>
     </div>

     <!-- Modal -->
     <div class="modal fade" id="patient_settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Новые данные</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="settings_modal">
          </div>
          <div class="modal-footer" id="settings_footer">
            
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/jquery.mask.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/swal.js"></script>
    <script src="view/js/Patients.js?0.13"></script>
  </body>
</html>