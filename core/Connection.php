<?php
class Connection{
    
    private $host, $user, $pass, $database, $charset, $port, $driver;
    
    public function conexion(){
        //holas
        if($this->driver=="mysqli" || $this->driver==null){
            $con = mysqli_connect('localhost','tickets_bd','1234','tickets_system_db');
            $con->set_charset("utf8");
            
            if(!$con){
                echo "No se puedo Conectar a la Base";
                exit();
            }             
        }
        
        return $con;
        
    }
          
    public function startFluent(){
        require_once "FluentPDO/FluentPDO.php";      
        	
        	try
        	{
        	   $pdo = new PDO('mysql:host=localhost;dbname=tickets_system_db', 'tickets_bd', '1234' );
        		
            	$fpdo = new FluentPDO($pdo);
            	
            }
            
            
            catch(Exception $err)
            {
            	echo "PDO No se puedo Conectar a la Base";
            	exit();
            }
        
        
        return $fpdo;
    }
}
?>