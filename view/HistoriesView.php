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
        <div class="row" style="padding-top: 10px;">
          <div class="col-xs-6 col-md-3 col-lg-3 text-left">
              
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
              
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
             
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
              <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search_patient" value="" onkeyup="loadPatients()" placeholder="Пойск">
                </div>
             </div>
             </div>
        </div>
        <div class="row" id="info_patient_story" style="padding-top: 5px;">
        </div>
	</div>
	<!-- Tabla de citas -->
	
	<div class="container-fluid" id="grad1" style="padding-top: 15px;">
    <div class="row justify-content-center mt-0">
        <div id="tabla_pacientes" class = "text-center col-md-10">
          <p>Идет загрузка...</p>
          <img src="view/universal/loading.gif" alt="loading" style="width:35%;height:auto;">
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="procedure_settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Допольнительная информация процедуры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="settings_modal">
        ...
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
    <script src="view/js/Histories.js?0.2"></script>
  </body>
</html>