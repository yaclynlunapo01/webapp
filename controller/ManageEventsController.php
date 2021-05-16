<?php 
class ManageEventsController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        session_start();

        if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==1)
        {
           $this->view("ManageEvents", array());
        }
        else
        {
            $pageName="NoAccess";
            $this->view("NoAcces",array("pageName"=>$pageName));
        }
        
    }

    public function getEventType()
    {
        $model = new MainModel();
        
        $columnas="id_tipo_evento, nombre_tipo_evento";
        $tablas="tipo_eventos";
        $where="1=1";
        $id="id_tipo_evento";
        $resultSet=$model->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }

    public function InsertEvent()
    {
        $model = new MainModel();

        $model->beginTran();
        
        $name = $_POST['event_name'];
        $type = $_POST['event_type'];
        $date = $_POST['event_date'];
        $time = $_POST['event_time'];
        $description = $_POST['event_description'];
        
        

        $columnas="eventos.fecha_evento";
        $tablas="eventos";
        $where="eventos.fecha_evento=\"".$date."\" AND eventos.id_estado_evento=1";
        $id="eventos.id_evento";
        $resultSet=$model->getCondiciones($columnas, $tablas, $where, $id);

        if (!empty($resultSet))
        {
            echo 0;
        }
        else
        {                         
            $query = "INSERT INTO eventos (nombre_evento, id_tipo_evento, fecha_evento, hora_evento, descripcion_evento, id_estado_evento)
                     VALUES ('".$name."',".$type.",'".$date."','".$time."','".$description."', 1)";
           
            $resultInsert=$model->executeNonQuery($query);
            $error = error_get_last();

            
            if ($resultInsert != "1" || !empty($error))
            {
                $model->endTran("ROLLBACK");

                echo "error ingreso evento".$error;
            }
            else
            {
                $model->endTran("COMMIT");
                echo "1";               
            }
        }       
   }    

    public function SalirSesion()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }    
    
}
?>