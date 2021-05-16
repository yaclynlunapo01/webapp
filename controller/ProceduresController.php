<?php 
class ProceduresController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Procedures";
        $tabName="Procedures";
        
        $this->view("Procedures",array("pageName"=>$pageName, "tabName"=>$tabName));
        
    }
    
    public function getProcedureType()
    {
        $procedures = new ProceduresModel();
        
        $columnas="id_tipo_procedimientos, nombre_tipo_procedimientos";
        $tablas="tipo_procedimientos";
        $where="1=1";
        $id="id_tipo_procedimientos";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function InsertProcedure()
    {
        $procedures = new ProceduresModel();
        
        $name = $_POST['procedure_name'];
        $cost  = $_POST['procedure_cost'];
        $type_id  = $_POST['procedure_type_id'];
        $duration =  $_POST['procedure_duration'];
        
        $columnas="id_procedimientos";
        $tablas="procedimientos INNER JOIN estados
                 ON procedimientos.id_estado_procedimientos = estados.id_estados";
        $where="nombre_procedimientos='".$name."' AND estados.nombre_estados='ACTIVO' AND precio_procedimientos=".$cost." AND id_tipo_procedimientos=".$type_id." AND duracion_procedimientos=".$duration;
        $id="id_procedimientos";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        $columnas="id_estados";
        $tablas="estados";
        $where="nombre_estados='ACTIVO' AND tabla_estados='procedimientos'";
        $id="id_estados";
        $estado=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        $estado = $estado[0]['id_estados'];
        
        
        if (empty($resultSet))
        {
            
            $query = "INSERT INTO procedimientos (nombre_procedimientos, precio_procedimientos, id_tipo_procedimientos, duracion_procedimientos, id_estado_procedimientos)
                     VALUES ('".$name."','".$cost."',".$type_id.",".$duration.",".$estado.")";
            
            $resultInsert=$procedures->executeNonQuery($query);
            
            echo $resultInsert;
        }
        else
        {
            echo "2";
        }
    }
    
    public function UpdateProcedureWOE()
    {
        $procedures = new ProceduresModel();
        
        $name = $_POST['procedure_name'];
        $cost  = $_POST['procedure_cost'];
        $duration =  $_POST['procedure_duration'];
        $procedure_id = $_POST['procedure_id'];
        
        $query = "UPDATE procedimientos
                  SET nombre_procedimientos='".$name."',
                      precio_procedimientos=".$cost.",
                      duracion_procedimientos=".$duration."
                  WHERE id_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        echo $resultInsert;
       
    }
    
    public function DeleteProcedureWOE()
    {
        $procedures = new ProceduresModel();
        
        $columnas = "id_estados";
        
        $tablas = "estados";
        
        $where    = "estados.nombre_estados='INACTIVO' AND tabla_estados='procedimientos'";
        
        $id       = "id_estados";

        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        $where    = "estados.nombre_estados='INACTIVO' AND tabla_estados='especificaciones_procedimientos'";
        
        $resultSet1=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        $procedure_id = $_POST['procedure_id'];
        
        $procedures->beginTran();
        
        $query = "UPDATE especificaciones_procedimientos
                  SET id_estados=".$resultSet1[0]['id_estados']."
                  WHERE id_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        $query = "UPDATE procedimientos
                  SET id_estado_procedimientos=".$resultSet[0]['id_estados']."
                  WHERE id_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        $error = error_get_last();
        
        if (empty($error))
        {
            $procedures->endTran("COMMIT");
        }
        else $procedures->endTran("ROLLBACK");
        
        
        echo $resultInsert;
        
    }
    
    public function DeleteExtra()
    {
        $procedures = new ProceduresModel();
        
        $columnas = "id_estados";
        
        $tablas = "estados";
        
        $where    = "estados.nombre_estados='INACTIVO' AND tabla_estados='especificaciones_procedimientos'";
        
        $id       = "id_estados";
        
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        $procedure_id = $_POST['procedure_id'];
        
        $query = "UPDATE especificaciones_procedimientos
                  SET id_estados=".$resultSet[0]['id_estados']."
                  WHERE id_especificaciones_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        echo $resultInsert;
        
    }
    
    public function UpdateProcedureExtra()
    {
        $procedures = new ProceduresModel();
        
        $name = $_POST['procedure_name'];
        $cost  = $_POST['procedure_cost'];
        $duration =  $_POST['procedure_duration'];
        $procedure_id = $_POST['procedure_id'];
        
        $query = "UPDATE especificaciones_procedimientos
                  SET nombre_especificaciones_procedimientos='".$name."',
                      costo_especificaciones_procedimientos=".$cost.",
                      duracion_especificaciones_procedimientos=".$duration."
                  WHERE id_especificaciones_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        echo $resultInsert;
        
    }
    
    public function UpdateProcedureWE()
    {
        $procedures = new ProceduresModel();
        
        $name = $_POST['procedure_name'];
        $procedure_id = $_POST['procedure_id'];
        
        $query = "UPDATE procedimientos
                  SET nombre_procedimientos='".$name."'
                  WHERE id_procedimientos=".$procedure_id;
        
        $resultInsert=$procedures->executeNonQuery($query);
        
        echo $resultInsert;
        
    }
    
    public function GetProceduresTable(){
                
        $procedures = new ProceduresModel();
        
        $where_to="";
        $columnas = "nombre_procedimientos,
                     precio_procedimientos,
                     id_procedimientos,
                     id_tipo_procedimientos,
                     duracion_procedimientos";
        
        $tablas = "procedimientos INNER JOIN estados
                   ON estados.id_estados = procedimientos.id_estado_procedimientos";
        
        
        $where    = "estados.nombre_estados='ACTIVO'";
        
        $id       = "id_procedimientos";
        
        
        $search =  (isset($_POST['search'])&& $_POST['search'] !=NULL)?$_POST['search']:'';
        $type =  (isset($_POST['type'])&& $_POST['type'] !=NULL)?$_POST['type']:'';
        
        
        if(!empty($search)){
            
            
            $where1=" AND (nombre_procedimientos LIKE '".$search."%')";
            
            $where.=$where1;
        }
        
        if(!empty($type)){
            
            
            $where2=" AND (id_tipo_procedimientos=".$type.")";
            
            $where.=$where2;
        }
        
        $where_to = $where;
        
        $html="";
                      
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where_to, $id);
        $cantidadResult = count($resultSet);
        
        if($cantidadResult>0)
        {
            
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<section>';
            $html.= "<table id='procedures_table_show' class='table table-bordered'>";
            $html.= "<thead>";
            $html.= "<tr>";
            $html.='<th></th>';
            $html.='<th>Процедура</th>';
            $html.='<th>Доп. информация</th>';
            $html.='<th>Продолжительность</th>';
            $html.='<th>Цена (руб.)</th>';
            $html.='</tr>';
            $html.='</thead>';
            $html.='<tbody>';
            
            
            $i=0;
            
            foreach ($resultSet as $res)
            {
                $columnas="nombre_especificaciones_procedimientos, costo_especificaciones_procedimientos, duracion_especificaciones_procedimientos";
                $tablas="especificaciones_procedimientos INNER JOIN estados
                         ON estados.id_estados = especificaciones_procedimientos.id_estados";
                $where="id_procedimientos=".$res['id_procedimientos']." AND estados.nombre_estados='ACTIVO'";
                $id="id_especificaciones_procedimientos";
                $resultSetExtras=$procedures->getCondiciones($columnas, $tablas, $where, $id);
                $extras_count=count($resultSetExtras);
                $i++;
                
                if ($extras_count>0)
                {
                    $html.='<tr>';
                    $html.='<td rowspan="'.$extras_count.'">'.$i.'</td>';
                    $html.='<td rowspan="'.$extras_count.'">'.$res['nombre_procedimientos'].'</td>';
                    $html.='<td>'.$resultSetExtras[0]['nombre_especificaciones_procedimientos'].'</td>';
                    $html.='<td>'.$resultSetExtras[0]['duracion_especificaciones_procedimientos'].'</td>';
                    $html.='<td>'.$resultSetExtras[0]['costo_especificaciones_procedimientos'].'</td>';
                    $html.='</tr>';
                    foreach(array_slice($resultSetExtras,1) as $resExtra)
                    {
                        $html.='<tr>';
                        $html.='<td>'.$resExtra['nombre_especificaciones_procedimientos'].'</td>';
                        $html.='<td>'.$resExtra['duracion_especificaciones_procedimientos'].'</td>';
                        $html.='<td>'.$resExtra['costo_especificaciones_procedimientos'].'</td>';
                        $html.='</tr>';
                    }
                    
                }
                else
                {
                    $html.='<tr>';
                    $html.='<td>'.$i.'</td>';
                    $html.='<td>'.$res['nombre_procedimientos'].'</td>';
                    if($res['id_tipo_procedimientos'] == 3)  $html.='<td>Количество зон</td>';
                    else $html.='<td></td>';
                    $html.='<td>'.$res['duracion_procedimientos'].'</td>';
                    $html.='<td>'.$res['precio_procedimientos'].'</td>';
                    $html.='</tr>';
                }
                
            }
            
            
            
            $html.='</tbody>';
            $html.='</table>';
            $html.='</section></div>';
            
            
            
            
        }else{
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Внимание!</h4> <b>Нет результатов по вашему запросу</b>';
            $html.='</div>';
            $html.='</div>';
        }
        
        
        echo $html;
        die();
        
        
        
    }
    
    public function GetProceduresTableEditable(){
        
        $procedures = new ProceduresModel();
        
        $where_to="";
        $columnas = "nombre_procedimientos,
                     precio_procedimientos,
                     id_procedimientos,
                     procedimientos.id_tipo_procedimientos,
                     duracion_procedimientos,
                     nombre_tipo_procedimientos";
        
        $tablas = "procedimientos INNER JOIN estados
                   ON estados.id_estados = procedimientos.id_estado_procedimientos
                   INNER JOIN tipo_procedimientos
                   ON procedimientos.id_tipo_procedimientos = tipo_procedimientos.id_tipo_procedimientos";
        
        
        $where    = "estados.nombre_estados='ACTIVO'";
        
        $id       = "id_procedimientos";
        
        
        $search =  (isset($_POST['search'])&& $_POST['search'] !=NULL)?$_POST['search']:'';
        $type =  (isset($_POST['type'])&& $_POST['type'] !=NULL)?$_POST['type']:'';
        
        
        if(!empty($search)){
            
            
            $where1=" AND (nombre_procedimientos LIKE '".$search."%')";
            
            $where.=$where1;
        }
        
        if(!empty($type)){
            
            
            $where2=" AND (id_tipo_procedimientos=".$type.")";
            
            $where.=$where2;
        }
        
        $where_to = $where;
        
        $html="";
        
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where_to, $id);
        $cantidadResult = count($resultSet);
        
        if($cantidadResult>0)
        {
            
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<section>';
            $html.= "<table id='procedures_table_show' class='table table-bordered'>";
            $html.= "<thead>";
            $html.= "<tr>";
            $html.='<th></th>';
            $html.='<th>Процедура</th>';
            $html.='<th>Доп. информация</th>';
            $html.='<th>Продолжительность</th>';
            $html.='<th>Цена (руб.)</th>';
            $html.='</tr>';
            $html.='</thead>';
            $html.='<tbody>';
            
            
            $i=0;
            
            foreach ($resultSet as $res)
            {
                $columnas="id_especificaciones_procedimientos,nombre_especificaciones_procedimientos, costo_especificaciones_procedimientos, duracion_especificaciones_procedimientos";
                $tablas="especificaciones_procedimientos INNER JOIN estados
                         ON estados.id_estados = especificaciones_procedimientos.id_estados";
                $where="id_procedimientos=".$res['id_procedimientos']." AND estados.nombre_estados='ACTIVO'";
                $id="id_especificaciones_procedimientos";
                $resultSetExtras=$procedures->getCondiciones($columnas, $tablas, $where, $id);
                $extras_count=count($resultSetExtras);
                $i++;
                
                if ($extras_count>0)
                {
                    $html.='<tr>';
                    $html.='<td rowspan="'.$extras_count.'">'.$i.'</td>';
                    $html.='<td rowspan="'.$extras_count.'">'.$res['nombre_procedimientos'].'<ul class="pagination float-right" style="display:inline-block">
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="EditProcedureWE('.$res['id_procedimientos'].')"><i class="fa fa-pencil"></i></a></span></li>
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="DeleteProcedureWOE('.$res['id_procedimientos'].')"><i class="fa fa-trash"></i></a></span></li>
					  </ul></td>';
                    $html.='<td>'.$resultSetExtras[0]['nombre_especificaciones_procedimientos'].'<ul class="pagination float-right" style="display:inline-block">
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="EditExtra('.$resultSetExtras[0]['id_especificaciones_procedimientos'].')"><i class="fa fa-pencil"></i></a></span></li>
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="DeleteExtra('.$resultSetExtras[0]['id_especificaciones_procedimientos'].')"><i class="fa fa-trash"></i></a></span></li>
					  </ul></td>';
                    $html.='<td>'.$resultSetExtras[0]['duracion_especificaciones_procedimientos'].'</td>';
                    $html.='<td>'.$resultSetExtras[0]['costo_especificaciones_procedimientos'].'</td>';
                    $html.='</tr>';
                    foreach(array_slice($resultSetExtras,1) as $resExtra)
                    {
                        $html.='<tr>';
                        $html.='<td>'.$resExtra['nombre_especificaciones_procedimientos'].'<ul class="pagination float-right" style="display:inline-block">
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="EditExtra('.$resExtra['id_especificaciones_procedimientos'].')"><i class="fa fa-pencil"></i></a></span></li>
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="DeleteExtra('.$resExtra['id_especificaciones_procedimientos'].')"><i class="fa fa-trash"></i></a></span></li>
					  </ul></td>';
                        $html.='<td>'.$resExtra['duracion_especificaciones_procedimientos'].'</td>';
                        $html.='<td>'.$resExtra['costo_especificaciones_procedimientos'].'</td>';
                        $html.='</tr>';
                    }
                    
                }
                else
                {
                    $html.='<tr>';
                    $html.='<td>'.$i.'</td>';
                    
                    if ($res['nombre_tipo_procedimientos'] == "ПО ЗОНАМ" || $res['nombre_tipo_procedimientos'] == "ПО ПРЕПАРАТАМ" || $res['nombre_tipo_procedimientos'] == "ПО ЭДИНИЦАМ" )
                    $html.='<td>'.$res['nombre_procedimientos'].'<ul class="pagination float-right" style="display:inline-block">
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="EditProcedureWE('.$res['id_procedimientos'].')"><i class="fa fa-pencil"></i></a></span></li>
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="DeleteProcedureWOE('.$res['id_procedimientos'].')"><i class="fa fa-trash"></i></a></span></li>
					  </ul></td>';
                    else
                        $html.='<td>'.$res['nombre_procedimientos'].'<ul class="pagination float-right" style="display:inline-block">
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="EditProcedureWOE('.$res['id_procedimientos'].')"><i class="fa fa-pencil"></i></a></span></li>
					  <li class="page-item" style="display:inline-block"><span><a class="page-link" onclick="DeleteProcedureWOE('.$res['id_procedimientos'].')"><i class="fa fa-trash"></i></a></span></li>
					  </ul></td>';
                    if($res['id_tipo_procedimientos'] == 3)  $html.='<td>Количество зон</td>';
                    else $html.='<td></td>';
                    $html.='<td>'.$res['duracion_procedimientos'].'</td>';
                    $html.='<td>'.$res['precio_procedimientos'].'</td>';
                    $html.='</tr>';
                }
                
            }
            
            
            
            $html.='</tbody>';
            $html.='</table>';
            $html.='</section></div>';
            
            
            
            
        }else{
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Внимание!</h4> <b>Нет результатов по вашему запросу</b>';
            $html.='</div>';
            $html.='</div>';
        }
        
        
        echo $html;
        die();
        
        
        
    }
    
    public function getProcedureInfoWE()
    {
        $procedures = new ProceduresModel();
        $procedure_id =  $_POST['procedure_id'];
        
        $columnas="nombre_procedimientos";
        $tablas="procedimientos";
        $where="id_procedimientos = ".$procedure_id;
        $id="id_procedimientos";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        echo $resultSet[0]['nombre_procedimientos'];
    }
    
    public function getProcedureInfoWOE()
    {
        $procedures = new ProceduresModel();
        $procedure_id =  $_POST['procedure_id'];
        
        $columnas="nombre_procedimientos, precio_procedimientos, duracion_procedimientos";
        $tablas="procedimientos";
        $where="id_procedimientos = ".$procedure_id;
        $id="id_procedimientos";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function getProcedureInfoExtra()
    {
        $procedures = new ProceduresModel();
        $procedure_id =  $_POST['procedure_id'];
        
        $columnas="nombre_especificaciones_procedimientos, costo_especificaciones_procedimientos, duracion_especificaciones_procedimientos";
        $tablas="especificaciones_procedimientos";
        $where="id_especificaciones_procedimientos = ".$procedure_id;
        $id="id_especificaciones_procedimientos";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
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