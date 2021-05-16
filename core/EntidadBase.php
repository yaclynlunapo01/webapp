<?php
class EntidadBase{
    private $table;
    private $db;
    private $conectar;
    
    
    public function __construct($table) {
        $this->table=(string) $table;
        
        require_once 'Connection.php';
        $this->conectar=new Connection();
        $this->db=$this->conectar->conexion();

        $this->fluent=$this->getConectar()->startFluent();
        $this->con=$this->getConectar()->conexion();
     }
    
     
    public function fluent(){
    	return $this->fluent;
    }
    
    public function con(){
    	return $this->con;
    }
    
    
    public function getConectar(){
        return $this->conectar;
    }
    
    public function db(){
        return $this->db;
    }
    
    //funciones para las transaciones
    public function beginTran(){
        
        $mysql_query = mysqli_query($this->con,"BEGIN");        
        
        return $mysql_query;
       
    }
    
    /***
     * dc 2019-05-17
     * desc: para finalizar una trasaccion en pg
     * @return resource
     */
    public function endTran($trans="ROLLBACK"){
        
        $mysql_query = mysqli_query($this->con,$trans);
        
        mysqli_close($this->con); 
        
        return $mysql_query;
        
    }
    
    public function getNuevo($secuencia){
    
    	$query=mysqli_query($this->con, "SELECT NEXTVAL('$secuencia')");
    	 
    	$resultSet = array();
    	 
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    	return $resultSet;
    }
    
    public function getAll($id){
        
    	$query=mysqli_query($this->con, "SELECT * FROM $this->table ORDER BY $id ASC");
    	$resultSet = array();
    	
           while ($row = mysqli_fetch_array($query)) {
             $resultSet[]=$row;
           }
        return $resultSet;
    }
    
    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
            
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
                
                return $_SERVER['REMOTE_ADDR'];
    }
    
    
    
    public function getContador($contador){
    
    	$query=mysqli_query($this->con, "SELECT $contador FROM $this->table ");
    	$resultSet = array();
    	 
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    	return $resultSet;
    }
    
    public function getCantidad($columna,$tabla,$where){
    
    	//parametro $columna puede ser todo (*) o una columna especifica
    	$query=mysqli_query($this->con, "SELECT COUNT($columna) AS total FROM $tabla WHERE $where ");
    	$resultSet = array();
    
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    	return $resultSet;
    }    
    
    
    public function getById($id){
    	
    	$query=mysqli_query($this->con, "SELECT * FROM $this->table WHERE id=$id");
        $resultSet = array();
    	
           while ($row = mysqli_fetch_array($query)) {
             $resultSet[]=$row;
           }
        return $resultSet;
    }
    
    public function getBy($where){
    	
    	$query=mysqli_query($this->con, "SELECT * FROM $this->table WHERE   $where ");
        $resultSet = array();
    	
           while ($row = mysqli_fetch_array($query)) {
             $resultSet[]=$row;
           }
        return $resultSet;
    }
    
    
    public function deleteById($id){
    	
        $query=mysqli_query($this->con,"DELETE FROM $this->table WHERE $id"); 
        return $query;
    }
    
    public function deleteByWhere($where){
        
        try
        {
            $query=mysqli_query($this->con,"DELETE FROM $this->table WHERE $where ");
        }
        catch (Exception $Ex)
        {
            
            
        }
        
        return $query;
    }
    
    public function deleteBy($column,$value){

    	try 
    	{
    		$query=mysqli_query($this->con,"DELETE FROM $this->table WHERE $column='$value' ");
    	}
    	catch (Exception $Ex)
    	{
    		
    		
    	} 
    	
        return $query;
    }
    
    public function eliminarBy($column,$value){
        
        $cantidadAfectada = null;
        
        try{
            
            $query=mysqli_query($this->con,"DELETE FROM $this->table WHERE $column='$value' ");
            
            if( $query === false )
                throw new Exception( "Error PostgreSQL ".pg_last_error() );
            
            $cantidadAfectada = mysqli_affected_rows($query);
            
        }catch (Exception $Ex){
            
            $cantidadAfectada=null;
        }
        
       
        return $cantidadAfectada;
    }
    
    public function eliminarByColumn($table,$column,$value){
        
        $cantidadAfectada = null;
        
        $query=mysqli_query($this->con,"DELETE FROM $table WHERE $column='$value' ");
        
        if($query){
            
            $cantidadAfectada = mysqli_affected_rows($query);
            
        }
        
        return $cantidadAfectada;
    }
    

    public function getCondiciones($columnas ,$tablas , $where, $id){
    	
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  ASC");
    	//echo "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  ASC";
    	$resultSet = array();
    	
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }

    public function getSelect($query){
    	
    	$query=mysqli_query($this->con, "SELECT $query");
    	//echo "SELECT $query";
    	$resultSet = array();
    	
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
    public function getCondicionesValorMayor($columnas ,$tablas , $where){
    	 
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where");
    	$resultSet = array();
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
    
    
    public function getCondicionesDesc($columnas ,$tablas , $where, $id){
    	 
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  DESC");
    	$resultSet = array();
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
    
 
   
    
    
    public function getCondicionesSinOrden($columnas ,$tablas , $where, $limit){
        
        $query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where $limit");
        $resultSet = array();
        while ($row = mysqli_fetch_array($query)) {
            $resultSet[]=$row;
        }
        
        return $resultSet;
    }
    
    
    public function getCondiciones_grupo($columnas ,$tablas , $where, $grupo, $id){
    	 
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where GROUP BY $grupo ORDER BY $id  ASC");
    	$resultSet = array();
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
  
    public function getCondicionesPag($columnas ,$tablas , $where, $id, $limit){
    	 
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  ASC  $limit");
    	
    	$resultSet = array();
    	while ($row = mysqli_fetch_array($query, MYSQLI_BOTH)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
      
    
    public function getCondicionesPagDesc($columnas ,$tablas , $where, $id, $limit){
    
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  DESC  $limit");
    	$resultSet = array();
    	while ($row = mysqli_fetch_array($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
    public function UpdateBy($colval ,$tabla , $where){
    	try 
    	{ 
    	     $query=mysqli_query($this->con, "UPDATE $tabla SET  $colval   WHERE $where ");
    	     
    	}
    	catch (Exception  $Ex)
    	{
    		
    		
    	}
    }
    
    public function ActualizarBy($colval ,$tabla , $where){
        try{
            
            $query=mysqli_query($this->con, "UPDATE $tabla SET  $colval   WHERE $where ");
            
            if( $query === false )
                throw new Exception("valor nulor");
            
            return pg_affected_rows($query);
            
        }catch (Exception  $Ex){
            return -1;
            
        }
    }
    
    public function editBy($colval ,$tabla , $where){
        
        $cantidadAfectada = null;
        
        $query=mysqli_query($this->con,"UPDATE $tabla SET  $colval   WHERE $where ");
        
        if(!$query){
            
            $cantidadAfectada = pg_last_error();
            
        }else{
            
            $cantidadAfectada = pg_affected_rows($query);
        }
        
        return $cantidadAfectada;
        
    }
    
    
    
    public function getByPDF($columnas, $tabla , $where){
    
    	if ($tabla == "")
    	{
    		$query=mysqli_query($this->con, "SELECT $columnas FROM $this->table WHERE   $where ");
    	}
    	else
    	{
    		$query=mysqli_query($this->con, "SELECT $columnas FROM $tabla WHERE   $where ");
    	}
    	
    	return $query;
    }
    
    public function getCondicionesPDF($columnas ,$tablas , $where, $id){
    	 
    	$query=mysqli_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  ASC");
    
    	return $query;
    }
    
    public function getSumaColumna($columna,$tabla,$where){
        
        //parametro $columna puede ser todo (*) o una columna especifica
        $query=mysqli_query($this->con, "SELECT SUM($columna) AS suma FROM $tabla WHERE $where ");
        $resultSet = array();
        
        while ($row = mysqli_fetch_array($query)) {
            $resultSet[]=$row;
        }
        return $resultSet;
    }  
    
    
    
    
    
}
?>
