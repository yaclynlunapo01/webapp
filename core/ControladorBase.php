<?php
class ControladorBase{

    public function __construct() {
        require_once 'EntidadBase.php';
        //require_once 'EntidadBaseSQL.php';
        require_once 'ModeloBase.php';
        
        //Incluir todos los modelos
        foreach(glob("model/*.php") as $file){
            require_once $file;
        }
    }
    
    //Plugins y funcionalidades
    
    public function view($vista,$datos){
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor; 
        }
        
        require_once 'core/AyudaVistas.php';
        $helper=new AyudaVistas();
    
        require_once 'view/'.$vista.'View.php';
    }
    
}
?>
