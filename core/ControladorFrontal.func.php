<?php
//FUNCIONES PARA EL CONTROLADOR FRONTAL

function cargarControlador($controller){
    $controlador=ucwords($controller).'Controller';
    $strFileController='controller/'.$controlador.'.php';
    
    if(!is_file($strFileController)){
        $strFileController='controller/'.ucwords(DEFAULT_CONTROLLER).'Controller.php';   
    }
    
    require_once $strFileController;
    $controllerObj=new $controlador();
    return $controllerObj;
}

function cargarAccion($controllerObj,$action){
    $accion=$action;
    $controllerObj->$accion();
}

function lanzarAccion($controllerObj){
    if (isset($_GET["controller"]))
    {
        if(isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
            cargarAccion($controllerObj, $_GET["action"]);
        }else{
            if (method_exists($controllerObj, DEFAULT_ACTION)) cargarAccion($controllerObj, DEFAULT_ACTION);
            else cargarAccion($controllerObj, NO_ACTION);
        }
    }
    else
    {
        cargarAccion($controllerObj, DEFAULT_ACTION);
    }
    
}

?>
