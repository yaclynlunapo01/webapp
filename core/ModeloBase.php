<?php
class ModeloBase extends EntidadBase{
    private $table;
    private $fluent;
    Private $con;
    
    public function __construct($table) {
        $this->table=(string) $table;
        parent::__construct($table);
        
        $this->fluent=$this->getConectar()->startFluent();
        $this->con=$this->getConectar()->conexion();
    }
    
    public function fluent(){
        return $this->fluent;
    }

    public function con(){
    	return $this->con;
    }
    
    public function ejecutarSql($query){
        $query=mysqli_query($this->con, $query);
        if($query==true){
            if(mysqli_num_rows($query)>1)
            {
                while($row = mysqli_fetch_array($query)) {
                   $resultSet[]=$row;
                }
            }
            elseif
            (mysqli_num_rows($query)==1){
                if($row = mysqli_fetch_array($query)) {
                    $resultSet=$row;
                }
            }
            else
            {
                $resultSet=true;
            }
        }
        else
        {
            $resultSet=false;
        }
        
        return $resultSet;
    }
    


    public function enviarSql($query){
    	
    	$result=mysqli_query($this->con, $query);

    	
    	if($result==true){

    		$resultSet = $result;
    		
    	}else{
    		
    	    $resultSet=null;
    	}
    
    	
    	return $resultSet;
    }
    
    

    public function enviarFuncion($query){

    	try 
    	{
    		mysqli_query($this->con, $query);
    		$resultSet= "Insertado Correctamente";
    	}
    	catch (Exception $Ex)
    	{
    		$resultSet = "Error al Insertar: " + $Ex->getMessage();
    		
    	}
    
    		 
    	return $resultSet;
    }
    
    
    
    

    public function ConsultaSql($query){
    	$resultSet = array();
    	
    	$query=mysqli_query($this->con, $query);
    	if($query==true)
    	{
    		if(mysqli_num_rows($query)>1)
    		{
    			
    			if($row = $row = pg_fetch_row($query)) {
    				$resultSet=$row;
    			}
    		}
    		elseif(mysqli_num_rows($query)==1){
    		   
    			if($row = pg_fetch_row($query)) {
    				$resultSet=$row;
    			}
    			
    			
    		}
    		else{
    		}
    	}else{
    	
    	}
    
    	return $resultSet;
    }
    
    
    
    
    /*Aqui podemos montarnos metodos para los modelos de consulta*/
    
    
    //----METODO PARA CONSULTAS DE INSERTADO CON DEVOLUCION DE DATOS 
    

    public function llamarconsulta($query){
        $resultSet=array();
        try{
            
            $result=mysqli_query($this->con(), $query);
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error() );
           
                
            if(mysqli_num_rows($result)>0)
            {                  
                while ($row = mysqli_fetch_array($result)) {
                    $resultSet[]=$row;
                }
            }
            
        }catch (Exception $Ex){
           
            $resultSet=null;
        }
        
        return $resultSet;
    }
    
    public function llamarconsultaPG($query){
        $resultSet=array();
        try{
            
            $result=mysqli_query($this->con(), $query);                   
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error() );
                
            if(mysqli_num_rows($result)>0)
            {
                $resultSet =  mysqli_fetch_array($result, 0, PGSQL_NUM);
            }
                
        }catch (Exception $Ex){
            
            $resultSet=null;
        }
        
        return $resultSet;
    }
    
    public function getconsultaPG($funcion,$parametros){
        return "SELECT ". $funcion." ( ".$parametros." )";
    }
    
    
    //------METODO PARA ENVIAR EL QUERY
    
    public function enviaquery($query){
        $resultSet=array();
        try{
            
            $result=mysqli_query($this->con(), $query);
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error() );
                
                
                if(mysqli_num_rows($result)>0)
                {
                    while ($row = mysqli_fetch_array($result)) {
                        $resultSet[]=$row;
                    }
                }
                
        }catch (Exception $Ex){
            
            $resultSet=null;
        }
        
        return $resultSet;
    }
    
    public function enviarNonQuery($query){
        $resultSet=array();
        try{
            
            $result=mysqli_query($this->con(), $query);
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error() );             
            
            $resultSet = mysqli_affected_rows($result);           
                
        }catch (Exception $Ex){
            
            $resultSet=null;
        }
        
        return $resultSet;
    }
    
    public function executeNonQuery($query){
        $resultSet=-1;
        try{
            
            $result=mysqli_query($this->con(), $query);
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error($this->con()) );
                
                $resultSet = mysqli_affected_rows($this->con());
                
        }catch (Exception $Ex){
            
            $resultSet=$Ex;
        }
        
        return $resultSet;
    }

    public function executeInsertQuery($query){
        $resultSet=-1;
        try{
            
            $result=mysqli_query($this->con(), $query);
            
            if( $result === false )
                throw new Exception( "Error MySQL ".mysqli_error() );

            if(mysqli_num_rows($result)>0)
            {
                $row    = mysqli_fetch_array($result);
                $resultSet = $row[0];
               
            }
            
                
        }catch (Exception $Ex){
            $resultSet=-1;
        }
        
        return $resultSet;
    }
    
    
}
?>


