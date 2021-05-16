<html lang="en">
    
    <?php include("view/universal/head.php")?>
  

  <body>

    <?php include("view/universal/navbar.php")?>

    
    <div class = "container-fluid text-center col-md-10" id="info_concierto">
    <p>Загрузка...</p>
    <img src="view/universal/loading.gif" alt="loading" style="width:15%;height:auto;">   
    </div>
    <div class = "container-fluid text-center col-md-10" id="boletos_concierto">
    
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
    <script src="view/js/ComprarBoleto.js?0.3"></script>