<html lang="en">
    <head>
    <?php include("view/universal/head.php")?>
  </head>

  <body>

    <?php include("view/universal/navbar.php")?>

    <div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
      <div class="card-body multi-collapse">
        <div class="row">
          <div class="col-xs-6 col-md-3 col-lg-3">

          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
              <input type="date" class="form-control" id="search_date_event" value="" onchange="GetAdminFeed()">
            </div>
          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
              <select id="concert_type_search"  class="form-control" onchange="GetAdminFeed()">
              <option value="" selected="selected">--Выбрать вид мероприятия:--</option>		
              </select> 
            </div>
          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
            <input type="text" class="form-control" id="search_event" value="" onkeyup="GetAdminFeed()"  placeholder="Пойск">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class = "container-fluid" id="conciertos_feed">
    
    </div>

    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/swal.js"></script>    
    <script src="view/js/AdminFeed.js?0.4"></script>