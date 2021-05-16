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
                <a class="nav-link <?php if($tabName=="NewAppointment") echo "active"; else echo "text-muted"?>" href="index.php?controller=Appointments&action=index"><h3>Новая Запись</h3></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if($tabName=="ShowAppointment") echo "active"; else echo "text-muted"?>" href="index.php?controller=ShowAppointments&action=index"><h3>Записи</h3></a>
              </li>
        </ul>
        <div class="row" style="padding-top: 10px;">
          <div class="col-xs-6 col-md-3 col-lg-3 text-left">
              
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
              
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
              <div class="form-group">
                     <select id="type_search"  class="form-control" onchange="loadAppointmentsTable()">
                         <option value="" selected="selected">--Выбрать вид:--</option>		
            </select> 
                 </div>
             </div>
             <div class="col-xs-6 col-md-3 col-lg-3 ">
              <div class="form-group">
                    <input type="date" class="form-control" id="search_date" value="" onchange="loadAppointmentsTable()">
                 </div>
             </div>
        </div>
	</div>
	<!-- Tabla de citas -->
	
	<div class="container-fluid" id="grad1" style="padding-top: 15px;">
    <div class="row justify-content-center mt-0">
        <div id="tabla_citas" class = "text-center col-md-10">
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
    <script src="view/js/ShowAppointments.js?0.6"></script>
  </body>
</html>