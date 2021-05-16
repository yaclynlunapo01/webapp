<html lang="en">
    
    <?php include("view/universal/head.php")?>
  

  <body>

    <?php include("view/universal/navbar.php")?>

    <div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
      <div class="card-body multi-collapse">
        <div class="row">
          <div class="col-xs-6 col-md-3 col-lg-3">

          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
              <input type="date" class="form-control" id="search_date_event" value="" onchange="GetConcertFeed()">
            </div>
          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
              <select id="concert_type_search"  class="form-control" onchange="GetConcertFeed()">
              <option value="" selected="selected">--Выбрать вид мероприятия:--</option>		
              </select> 
            </div>
          </div>
          <div class="col-xs-6 col-md-3 col-lg-3 ">
            <div class="form-group">
            <input type="text" class="form-control" id="search_event" value="" onkeyup="GetConcertFeed()"  placeholder="Пойск">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class = "container-fluid" id="conciertos_feed">   
    </div>

  </div>

    <!--Modal asientos-->
    <div class="modal fade" id="asientosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id = "Asientos"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!--Fin Modal-->
  </body>

    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/flexiseats.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>    
    <script type="text/javascript" src="bootstrap/swal.js"></script>    
    <script src="view/js/ConcertFeed.js?0.4"></script>