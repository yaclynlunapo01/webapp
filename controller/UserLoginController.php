<?php 
class UserLoginController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function Login(){
        session_start();
        if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==1)
        {
            $pageName="AdminFeed";
        $this->view("AdminFeed",array("pageName"=>$pageName));
        }
        else if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==2 )
        {
            $pageName="ConcertFeed";
            $this->view("ConcertFeed",array("pageName"=>$pageName));
        }
        else
        {
            $pageName="UserLogin";
            $this->view("UserLogin",array("pageName"=>$pageName));
        }
        
        
    }
    
    public function RedirectToFeed()
    {
        session_start();
        if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==1)
        {
            echo "admin";
        }
        else if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==2 )
        {
            echo "user";
        }
        else
        {
            echo "wtf";
        }
                
    }
    
    public function GetLoginInfo()
    {
        $model = new MainModel();
        
        $login_user = $_POST['login_user'];
        $password_user = $_POST['password_user'];
        
        $columnas="credenciales_usuarios.id_usuarios, usuarios.id_rol_usuarios";
        $tablas="credenciales_usuarios INNER JOIN usuarios
        ON credenciales_usuarios.id_usuarios = usuarios.id_usuarios";
        $where="credenciales_usuarios.login_usuarios=\"".$login_user."\" 
        AND credenciales_usuarios.contrasena_usuarios = \"".$password_user."\"";
        $id="credenciales_usuarios.id_usuarios";
        $resultSet=$model->getCondiciones($columnas, $tablas, $where, $id);

        if (empty($resultSet))
        {
            $where="credenciales_usuarios.login_usuarios=\"".$login_user."\"";
            $resultSet=$model->getCondiciones($columnas, $tablas, $where, $id);
            if(empty($resultSet)) echo 0;
            else echo 2;
        }
        else
        {
            
         session_start();
         $_SESSION['id_rol_usuario']=$resultSet[0]['id_rol_usuarios'];
         $_SESSION['id_usuarios']=$resultSet[0]['id_usuarios'];
         echo 1;
        }
               
    }

    public function InsertUser()
    {
        $model = new MainModel();

        $model2 = new MainModel();

        $model2->beginTran();
        
        $name = $_POST['user_name'];
        $surname = $_POST['user_surname'];
        $patronimic = $_POST['user_patronimic'];
        $birthday = $_POST['user_dob'];
        $password = $_POST['user_password'];
        $mail = $_POST['user_mail'];

        $columnas="usuarios.id_usuarios";
        $tablas="usuarios";
        $where="usuarios.correo_usuarios=\"".$mail."\"";
        $id="usuarios.id_usuarios";
        $resultSet=$model->getCondiciones($columnas, $tablas, $where, $id);

        if (!empty($resultSet))
        {
            echo 0;
        }
        else
        {           
            $selec_last_id=" `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'tickets_system_db' AND TABLE_NAME = 'usuarios'";
            $id_usuarios=$model->getSelect($selec_last_id);

            $id_usuarios=$id_usuarios[0]['AUTO_INCREMENT'];
            
            $query = "INSERT INTO usuarios (nombre, apellido, patronimico, correo_usuarios, fecha_nacimiento_usuarios, id_rol_usuarios)
                     VALUES ('".$name."','".$surname."','".$patronimic."','".$mail."','".$birthday."', 2)";
           
            $resultInsert=$model2->executeNonQuery($query);
            $error = error_get_last();

            
            if ($resultInsert != "1" || !empty($error))
            {
                $model2->endTran("ROLLBACK");

                echo "error ingreso usuario".$error;
            }
            else
            {
               

                $query = "INSERT INTO credenciales_usuarios (id_usuarios, login_usuarios, contrasena_usuarios)
                     VALUES (".$id_usuarios.",'".$mail."','".$password."')";
           
                $resultInsert=$model2->executeNonQuery($query);
                $error = error_get_last();

                if ($resultInsert != "1" || !empty($error))
                {
                    $model2->endTran("ROLLBACK");

                    echo "error ingreso credencial".$error.$id_usuarios;
                }
                else
                {
                    $model2->endTran("COMMIT");
                    echo "1";
                }
               
            }
        }       
   }    
}
?>