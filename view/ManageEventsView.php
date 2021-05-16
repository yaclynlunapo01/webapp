<html lang="en">
    <head>
    <?php include("view/universal/head.php")?>
  </head>

  <body>

    <?php include("view/universal/navbar.php")?>

    <div class="card-body">
      <div class="row">
        <div class="col-xs-6 col-md-3 col-lg-3 ">
          <div class="form-group">
            <label class="control-label">Вид мероприятия:</label>
            <select id="event_type"  class="form-control">
              <option value="" selected="selected">--Выбрать вид мероприятия:--</option>		
            </select> 
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 ">
          <div class="form-group">
            <label class="control-label">Название мероприятия:</label>
            <input type="text" class="form-control" id="event_name" value=""  placeholder="Название">
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 ">
          <div class="form-group">
            <label class="control-label">Дата мероприятия:</label>
            <input class="form-control" type="date" value="" id="event_date">
          </div>
        </div>
        <div class="col-xs-6 col-md-3 col-lg-3 ">
          <div class="form-group">
            <label class="control-label">Времия мероприятия:</label>
            <input type="time" class="form-control" id="event_time" value=""  placeholder="">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label class="control-label">Описание мероприятия:</label>
          <textarea  type="text" class="form-control" rows="3" maxlength="255" id="event_description" value=""  placeholder="Описание мероприятия"></textarea>
        </div>	
      </div>
      <div class="row" style="padding-top: 1%;">
        <div class="col text-center">
          <button type="button" class="btn btn-primary" onclick="saveEvent()">Создать</button>
          <button type="button" class="btn btn-danger" onclick="cancelarRegistro()">Отменить</button>
        </div>
      </div>
    </div>

  </body>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/swal.js"></script>    
    <script src="view/js/ManageEvents.js?0.3"></script>