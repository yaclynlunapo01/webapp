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
            <a class="nav-link <?php if($tabName=="Procedures") echo "active"; else echo "text-muted"?>" href="index.php?controller=Procedures&action=index"><h3>Процедуры</h3></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Zones") echo "active"; else echo "text-muted"?>" href="index.php?controller=Zones&action=index"><h3>Зоны</h3></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($tabName=="Preparats") echo "active"; else echo "text-muted"?>" href="index.php?controller=Preparats&action=index"><h3>Препараты</h3></a>
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
          <div class="card-body multi-collapse">
            <div class="row">
            	<div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label for="cedula_usuarios" class="control-label">Название препарата:</label>
                        <input type="text" class="form-control" id="cedula_usuarios" name="cedula_usuarios" value=""  placeholder="Название">
                        <div id="mensaje_cedula_usuarios" class="errores"></div>
                     </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                    	<label for="cedula_usuarios" class="control-label">Стоитмость препарата:</label>
                        <input type="text" class="form-control" id="cedula_usuarios" name="cedula_usuarios" value=""  placeholder="Стоитмость">
                        <div id="mensaje_cedula_usuarios" class="errores"></div>
                     </div>
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
            </div>
            <div class="row">
            	<div class="col text-center">
            		<button type="button" class="btn btn-primary">Сохранить</button>
            		<button type="button" class="btn btn-danger">Отменить</button>
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
          	Процедуры
            <button class="btn float-right" data-toggle="collapse" data-target="#collapseTable" aria-expanded="false" aria-controls="collapseTable">
              <i class="fa fa-caret-square-o-up fa-lg"></i>
            </button>
          </h3>
        </div>
    
        <div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
          <div class="card-body multi-collapse">
            <div class="row">
            	<div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	
                 </div>
                 <div class="col-xs-6 col-md-3 col-lg-3 ">
                	<div class="form-group">
                        <input type="text" class="form-control" id="cedula_usuarios" name="cedula_usuarios" value=""  placeholder="Пойск">
                        <div id="mensaje_cedula_usuarios" class="errores"></div>
                     </div>
                 </div>
            </div>
          </div>
        </div>
      </div>
     </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="view/js/Preparats.js?0.1"></script>
  </body>
</html>