<?php 
class ExtrasController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Procedures";
        $tabName="Extras";
        
        $this->view("Extras",array("pageName"=>$pageName, "tabName"=>$tabName));
        
    }
    
    public function getProcedures()
    {
        $extras = new ExtrasModel();
        
        $columnas="procedimientos.id_procedimientos, procedimientos.nombre_procedimientos";
        $tablas="procedimientos INNER JOIN tipo_procedimientos
                 ON procedimientos.id_tipo_procedimientos = tipo_procedimientos.id_tipo_procedimientos
                 INNER JOIN estados
                 ON estados.id_estados = procedimientos.id_estado_procedimientos";
        $where="tipo_procedimientos.nombre_tipo_procedimientos <> 'БЕЗ ДОП.' AND tipo_procedimientos.nombre_tipo_procedimientos <> 'ПО КОЛ-ВУ ЗОН' AND nombre_estados='ACTIVO'";
        $id="id_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function InsertProcedureExtra()
    {
        $extras = new ExtrasModel();
        
        $name = $_POST['extra_name'];
        $cost  = $_POST['extra_cost'];
        $procedure_id  = $_POST['procedure_id'];
        $duration = $_POST['extra_duration'];
        
        $columnas="id_especificaciones_procedimientos";
        $tablas="especificaciones_procedimientos";
        $where="nombre_especificaciones_procedimientos='".$name."' AND costo_especificaciones_procedimientos=".$cost." AND id_procedimientos=".$procedure_id." AND duracion_especificaciones_procedimientos=".$duration;
        $id="id_especificaciones_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        $columnas="id_estados";
        $tablas="estados";
        $where="nombre_estados='ACTIVO' AND tabla_estados='especificaciones_procedimientos'";
        $id="id_estados";
        $estado=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        $estado = $estado[0]['id_estados'];
        
        if (empty($resultSet))
        {
            
            $query = "INSERT INTO especificaciones_procedimientos (nombre_especificaciones_procedimientos, costo_especificaciones_procedimientos, id_procedimientos, duracion_especificaciones_procedimientos, id_estados)
                     VALUES ('".$name."','".$cost."',".$procedure_id.",".$duration.",".$estado.")";
            
            $resultInsert=$extras->executeNonQuery($query);
            
            echo $resultInsert;
        }
        else
        {
            echo "2";
        }
    }
    
    public function getProcedureType()
    {
        $extras = new ExtrasModel();
        
        $id_tipo_procedimiento = $_POST['id_tipo_procedimiento'];
        
        $columnas="tipo_procedimientos.nombre_tipo_procedimientos";
        $tablas="tipo_procedimientos INNER JOIN procedimientos
                 ON tipo_procedimientos.id_tipo_procedimientos = procedimientos.id_tipo_procedimientos";
        $where="procedimientos.id_procedimientos = ".$id_tipo_procedimiento;
        $id="tipo_procedimientos.id_tipo_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }

    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
    
}
?>