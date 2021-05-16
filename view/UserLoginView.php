<!doctype html>
<html lang="en">
  <?php include("view/universal/head.php")?>
  <style>
  html,body{
    background-image: url('view/universal/bg-login.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    font-family: 'Numans', sans-serif;
    }
    
    .container{
    height: 100%;
    align-content: center;
    }
    
    .card{
    height: 370px;
    margin-top: auto;
    margin-bottom: auto;
    width: 400px;
    background-color: rgba(0,0,0,0.5) !important;
    }

    .card_register{
    height: 490px;
    margin-top: auto;
    margin-bottom: auto;
    width: 400px;
    background-color: rgba(0,0,0,0.5) !important;
    }
  </style>
  <body>
  
  	<!--Navigation  -->
    
   
    
    <!-- Page tittle -->
    <div id="login_container" class="container h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="card">
          <div class="card-header bg-secondary">
            <h3 style="text-align: center;" class="text-white">
              <font style="color: #F9FF2C;">V</font><font style="color: #2836fe;">E</font><font style="color: #FE3C28;">N</font>
              TICKET</h3>
          </div>
          <div class="card-body">
            <form>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <input id="login_usuario" type="text" class="form-control" placeholder="логин">
                
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>
                <input id="password_usuario" type="password" class="form-control" placeholder="парол">
              </div>
              <div class="form-group text-center">
                <button type="button" class="btn btn-primary" onclick="LoginUsuario()">Войти</button>
              </div>
              <div class="form-group text-center">
                <a href="#" onclick="RegistrarNuevoUsuario()">Регистрироваться</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="register_container" class="container h-100" style = "display: none;">
      <div class="row justify-content-center align-items-center h-100">
        <div class="card_register">
          <div class="card-header bg-secondary">
            <h3 style="text-align: center;" class="text-white">
              <font style="color: #F9FF2C;">V</font><font style="color: #2836fe;">E</font><font style="color: #FE3C28;">N</font>
              TICKET</h3>
          </div>
          <div class="card-body">
            <form>
              <div class="input-group form-group">
                <input id="user_name_register" type="text" class="form-control" placeholder="имя">
              </div>              
              <div class="input-group form-group">
                <input id="user_surname_register" type="text" class="form-control" placeholder="фамилия">
              </div>              
              <div class="input-group form-group">
                <input id="user_patronimic_register" type="text" class="form-control" placeholder="отечество">
              </div>
              <label class="control-label "><font style="color: #ffffff;">Дата рождения:</font></label>
              <div class="input-group form-group">
                
                <input type="date" class="form-control" id="user_dob_register" placeholder="дата рождения" /> 
              </div>              
              <div class="input-group form-group">
                <input id="user_email_register" type="text" class="form-control" placeholder="почта">
              </div>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>
                <input id="user_password_register" type="password" class="form-control" placeholder="парол">
              </div>
              <div class="form-group text-center">
                <button type="button" class="btn btn-primary" onclick="ValidarRegistro()">Регистрироваться</button>
                <button type="button" class="btn btn-danger" onclick="CancelRegister()">Отмена</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
	<!-- Tabla de citas -->
	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bootstrap/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper.min.js" ></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrap/swal.js"></script>    
    <script src="view/js/UserLogin.js?0.4"></script>
  </body>
</html>