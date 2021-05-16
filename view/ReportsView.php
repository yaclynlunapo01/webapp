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
            <a class="nav-link active" href="#"><h3>Отчеты</h3></a>
          </li>
        </ul>
	</div>
	<!-- Tabla de citas -->
	<div class="row">
    <div class="col-xs-6 col-md-4 col-lg-4 ">
      <div class="card bg-light">
        <div class="card-header">
          <h3 class = "text-center">За день</h3>
        </div>
        <div class= "card-body">
          <input class="form-control" type="date" value="" id="report-day">
          <br>
          <div class="col text-center">
            <button type="button" class="btn btn-primary" formtarget="_blank" onclick="getDay()">Открыть</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-4 col-lg-4 ">
      <div class="card bg-light">
        <div class="card-header">
          <h3 class = "text-center">За месяц</h3>
        </div>
        <div class= "card-body">          
          <select id="anio_mes_reporte"  class="form-control" onchange="getMonths()">
            <option value="" selected="selected">--Выбрать год отчета:--</option>		
          </select>
          <div id="mes_mes_reporte">
          </div> 
        </div>
      </div>
    </div>
    <div class="col-xs-6 col-md-4 col-lg-4 ">
      <div class="card bg-light">
        <div class="card-header">
          <h3 class = "text-center">За год</h3>
        </div>
        <div class= "card-body">
          <select id="anio_reporte"  class="form-control"">
            <option value="" selected="selected">--Выбрать год отчета:--</option>		
          </select>
          <br>
          <div class="col text-center">
            <button type="button" class="btn btn-primary" onclick="getYear()">Открыть</button>
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
    <script src="view/js/Reports.js?0.4"></script>
  </body>
</html>