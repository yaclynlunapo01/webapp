<?php 
require_once 'config/global.php';

require_once 'core/ControladorBase.php';

require_once 'core/ControladorFrontal.func.php';

if(isset($_GET["controller"])){
    $controllerObj=cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
}else{
    $controllerObj=cargarControlador(DEFAULT_CONTROLLER);
    lanzarAccion($controllerObj);
}
	
?>