<?php 
class AppointmentsController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Appointments";
        $tabName="NewAppointment";

        $this->view("Appointments",array("pageName"=>$pageName, "tabName"=>$tabName));
        
    }

    public function GetPatients(){
        
        
        
        $patients = new PatientsModel();
       
        $where_to="";
        $columnas = "imya_pacientes,
                     familia_pacientes,
                     ochestvo_pacientes,
                     telefon_pacientes,
                     fecha_n_pacientes,
                     id_pacientes";
        
        $tablas = "pacientes";
        
        
        $where    = "1=1";
        
        $id       = "id_pacientes";
        
        
        $search =  (isset($_POST['search'])&& $_POST['search'] !=NULL)?$_POST['search']:'';
       
            
            
            if(!empty($search)){
                
                
                $where1=" AND (imya_pacientes LIKE '".$search."%' OR familia_pacientes LIKE '".$search."%' OR ochestvo_pacientes LIKE '".$search."%' OR telefon_pacientes LIKE '".$search."%' )";
                
                $where_to=$where.$where1;
            }else{
                
                $where_to=$where;
                
            }
            
            $html="";
            $resultSet=$patients->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]['total'];
            
            
            $page = (isset($_POST['page']) && !empty($_POST['page']))?$_POST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   ".$per_page." OFFSET ".$offset;
            
            $resultSet=$patients->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
            $count_query   = $cantidadResult;
            $total_pages = ceil($cantidadResult/$per_page);
            
            
            if($cantidadResult>0)
            {
                
                $html.='<div class="card float-right w-20">';
                $html.='<div class="card body">';
                //$html.='<div class="col-xs-6 col-md-3 col-lg-3 ">';
                $html.='<span class="form-control"><strong>Найдено: </strong>'.$cantidadResult.'</span>';
                $html.='</div>';
                $html.='</div>';
                $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
                $html.='<section>';
                $html.= "<table id='patients_table_show' class='table table-striped'>";
                $html.= "<thead>";
                $html.= "<tr>";
                $html.='<th></th>';
                $html.='<th>ФИО</th>';
                $html.='<th>Телефон</th>';
                $html.='<th>Дата Рождения</th>';
                $html.='<th></th>';
                $html.='</tr>';
                $html.='</thead>';
                $html.='<tbody>';
                
                
                $i=0;
                
                foreach ($resultSet as $res)
                {
                    $i++;
                    $html.='<tr>';
                    $html.='<td>'.$i.'</td>';
                    $html.='<td>'.$res['familia_pacientes'].' '.$res['imya_pacientes'].' '.$res['ochestvo_pacientes'].'</td>';
                    $html.='<td>'.$res['telefon_pacientes'].'</td>';
                    $html.='<td>'.$res['fecha_n_pacientes'].'</td>';
                    $html.='<td><button type="button" class="btn btn-success" onclick="findPatient('.$res['id_pacientes'].')"><i class="fa fa-share"></i></button></td>';
                    $html.='</tr>';
                }
                
                $html.='<tr>';
                $html.='<td colspan="5">';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_patients("index.php", $page, $total_pages, $adjacents,"loadPatients").'';
                $html.='</div>';
                $html.='</td>';
                $html.='</tr>';
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section>';
                $html.='</div>';
                
                
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
    
    public function paginate_patients($reload, $page, $tpages, $adjacents,$funcion='') {
        
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $out = '<ul class="pagination">';
        
        // previous label
        
        if($page==1) {
            $out.= "<li class='page-item disabled'><span><a class='page-link'>$prevlabel</a></span></li>";
        } else if($page==2) {
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>$prevlabel</a></span></li>";
        }else {
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(".($page-1).")'>$prevlabel</a></span></li>";
            
        }
        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>1</a></li>";
        }
        // interval
        if($page>($adjacents+2)) {
            $out.= "<li class='page-item'><a class='page-link'>...</a></li>";
        }
        
        // pages
        
        $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
        $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
        for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$page) {
                $out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
            }else if($i==1) {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(1)'>$i</a></li>";
            }else {
                $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion(".$i.")'>$i</a></li>";
            }
        }
        
        // interval
        
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li class='page-item'><a class='page-link'>...</a></li>";
        }
        
        // last
        
        if($page<($tpages-$adjacents)) {
            $out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='$funcion($tpages)'>$tpages</a></li>";
        }
        
        // next
        
        if($page<$tpages) {
            $out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='$funcion(".($page+1).")'>$nextlabel</a></span></li>";
        }else {
            $out.= "<li class='page-item disabled'><span><a class='page-link'>$nextlabel</a></span></li>";
        }
        
        $out.= "</ul>";
        return $out;
    }


    public function FindPatient()
    {
        $patients = new PatientsModel();
        
        $id_paciente = $_POST['patient_id'];
        
        $columnas="id_pacientes, imya_pacientes, familia_pacientes, ochestvo_pacientes, fecha_n_pacientes, telefon_pacientes";
        $tablas="pacientes";
        $where="id_pacientes=".$id_paciente;
        $id="id_pacientes";
        $resultSet=$patients->getCondiciones($columnas, $tablas, $where, $id);
        
        if (empty($resultSet))
        {echo 0;}
        else
        {
            echo json_encode($resultSet);
        }
               
    }
    
    public function getProcedures()
    {
        $extras = new ExtrasModel();
        
        $columnas="procedimientos.id_procedimientos, procedimientos.nombre_procedimientos";
        $tablas="procedimientos INNER JOIN estados
                 ON estados.id_estados = procedimientos.id_estado_procedimientos";
        $where="nombre_estados ='ACTIVO' AND tabla_estados='procedimientos'";
        $id="id_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function getProcedureZones()
    {
        $extras = new ExtrasModel();
        
        $id_procedimiento = $_POST['id_procedure'];
        
        $columnas="especificaciones_procedimientos.id_especificaciones_procedimientos, especificaciones_procedimientos.nombre_especificaciones_procedimientos";
        $tablas="procedimientos INNER JOIN especificaciones_procedimientos
                 ON procedimientos.id_procedimientos = especificaciones_procedimientos.id_procedimientos
                 INNER JOIN estados
                 ON estados.id_estados = especificaciones_procedimientos.id_estados";
        $where="especificaciones_procedimientos.id_procedimientos=".$id_procedimiento." AND nombre_estados ='ACTIVO' AND tabla_estados='especificaciones_procedimientos'";
        $id="especificaciones_procedimientos.id_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function getExtraCost()
    {
        $extras = new ExtrasModel();
        
        $id_especificacion_procedimiento = $_POST['id_especificacion_procedimiento'];
        
        $columnas="costo_especificaciones_procedimientos, duracion_especificaciones_procedimientos";
        $tablas="especificaciones_procedimientos";
        $where="id_especificaciones_procedimientos =".$id_especificacion_procedimiento;
        $id="id_especificaciones_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }
    
    public function getAvailableHour() 
    {
        $extras = new ExtrasModel();

        $procedure_table = json_decode(stripslashes($_POST['procedure_table']));
        $appointment_date = $_POST['selected_date'];
        $procedimientos_dia = array();

        $columnas="citas.id_citas, citas.hora_citas";
        $tablas="citas INNER JOIN estados
                ON citas.id_estados = estados.id_estados";
        $where="citas.fecha_citas ='".$appointment_date."' AND estados.nombre_estados='ACTIVO'";
        $id="citas.hora_citas";
        $resultCitas=$extras->getCondiciones($columnas, $tablas, $where, $id);

        foreach ($resultCitas as $citas)
        {
            $columnas="extra_procedimientos.id_procedimientos, extra_procedimientos.id_especificacion_procedimientos,
                        extra_procedimientos.orden_extra_procedimientos";
            $tablas="extra_procedimientos";
            $where="id_citas =".$citas['id_citas'];
            $id="extra_procedimientos.orden_extra_procedimientos";
            $resultProcedimientos=$extras->getCondiciones($columnas, $tablas, $where, $id);
            $starting_time = $citas['hora_citas'];
            $starting_time=date('H:i', strtotime($starting_time));
            foreach($resultProcedimientos as $procs)
            {
                if(empty($procs['id_especificacion_procedimientos']))
                {
                    $columnas="duracion_procedimientos";
                    $tablas="procedimientos";
                    $where="id_procedimientos =".$procs['id_procedimientos'];
                    $id="id_procedimientos";
                    $resultProcedimientos=$extras->getCondiciones($columnas, $tablas, $where, $id);
                    
                    for($i=0; $i<($resultProcedimientos[0]['duracion_procedimientos'])/30; $i++)
                    {
                        $endTime = strtotime("+30 minutes", strtotime($starting_time));
                        if($procs['id_procedimientos']==4) $info_t_proc=array($starting_time, 1);
                        else if($procs['id_procedimientos']==8) $info_t_proc=array($starting_time, 2);
                        else $info_t_proc=array($starting_time, 0);
                        $starting_time=date('H:i', $endTime);
                        array_push($procedimientos_dia, $info_t_proc);
                    }
                    
                }
                else
                {
                    $columnas="duracion_especificaciones_procedimientos";
                    $tablas="especificaciones_procedimientos";
                    $where="id_especificaciones_procedimientos =".$procs['id_especificacion_procedimientos'];
                    $id="id_especificaciones_procedimientos";
                    $resultProcedimientos=$extras->getCondiciones($columnas, $tablas, $where, $id);
                    for($i=0; $i<($resultProcedimientos[0]['duracion_especificaciones_procedimientos'])/30; $i++)
                    {
                        $endTime = strtotime("+30 minutes", strtotime($starting_time));
                        $info_t_proc=array($starting_time, 0);
                        $starting_time=date('H:i', $endTime);
                        array_push($procedimientos_dia, $info_t_proc);
                    }
                    
                }
            }

        }
        
        $day_schedule = array();
        
        $starting_time = "8:00";
        $finish_time = "19:30";
        $limit_time = strtotime("+30 minutes", strtotime($finish_time));
        $periodo = array($starting_time,-1);
        array_push($day_schedule,$periodo);
        while($starting_time != $finish_time)
        {
            $endTime = strtotime("+30 minutes", strtotime($starting_time));
            $starting_time=date('H:i', $endTime);
            $periodo = array($starting_time,-1);
             array_push($day_schedule,$periodo);
        }
        
        foreach ($day_schedule as $key => $field)
        {
            foreach ($procedimientos_dia as $prd1)
            {
                if($field[0]==$prd1[0])
                {
                    $day_schedule[$key][1] =$prd1[1];
                }
               
            }
        }

        $to_schedule=array();
        foreach ($procedure_table as $p)
        {
            for($i=0; $i<($p[1])/30; $i++)
            {
                $slot = array("",$p[0]);
                array_push($to_schedule,$slot);
            }
        }

        $html = '<select id="appointment_time"  class="form-control" >
         			<option value="" selected="selected">--Выберите время--</option>';

        foreach($day_schedule as $d)
        {
            $add_flag=1;
            $time = $d[0];
            
          foreach($to_schedule as $key => $field)
          {
            
            $to_schedule[$key][0]=$time;
            $endtime = strtotime("+30 minutes", strtotime($time));
            $time=date('H:i', $endtime);
            
            if(strtotime($time)> $limit_time) $add_flag=0;
          }
          
          foreach($to_schedule as $slot)
          {     
              
              foreach($day_schedule as $day1)
              {
                if($day1[0]==$slot[0])
                {
                    
                    if ($day1[1]==$slot[1]) $add_flag=0;
                }
              }
          }
          if ($add_flag==1)
          {
            $html.='<option value="'.$d[0].'" selected="">'.$d[0].'</option>';
          }
        }
        
        $html.='</select>';
        echo $html;
        
    }

    public function InsertAppointment()
    {
        $appointment = new ExtrasModel();
        
        $name = $_POST['patient_name'];
        $surname = $_POST['patient_surname'];
        $patronimic = $_POST['patient_patronimic'];
        $birthday = $_POST['patient_birthday'];
        $phone = $_POST['patient_phone'];
        $date = $_POST['appointment_date'];
        $time = $_POST['appointment_time'];
        $duration = $_POST['appointment_duration'];
        $observation = $_POST['appointment_observation'];
        $table = json_decode(stripslashes($_POST['procedure_table']));
       
               
        $columnas="id_pacientes";
        $tablas="pacientes";
        $where="imya_pacientes='".$name."' AND familia_pacientes='".$surname."' AND ochestvo_pacientes='".$patronimic."'AND telefon_pacientes='".$phone."' AND fecha_n_pacientes='".$birthday."'";
        $id="id_pacientes";
        $id_paciente=$appointment->getCondiciones($columnas, $tablas, $where, $id);

        $id_paciente=$id_paciente[0]['id_pacientes'];

        $columnas="id_estados";
        $tablas="estados";
        $where="tabla_estados='citas' AND nombre_estados = 'ACTIVO'";
        $id="id_estados";
        $id_estado=$appointment->getCondiciones($columnas, $tablas, $where, $id);

        $id_estado=$id_estado[0]['id_estados'];
                
        $appointment->beginTran();
        $selec_last_id=" `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'clinic_db' AND TABLE_NAME = 'citas'";
                        $id_citas=$appointment->getSelect($selec_last_id);

                        $id_citas=$id_citas[0]['AUTO_INCREMENT'];
            
            $query = "INSERT INTO citas (fecha_citas, hora_citas, duracion_citas, id_paciente_citas, id_estados, observacion_citas)
                     VALUES ('".$date."','".$time."',".$duration.",".$id_paciente.",".$id_estado.", '".$observation."')";
           
            $resultInsert=$appointment->executeNonQuery($query);
            $error = error_get_last();


            if ($resultInsert != "1" || !empty($error))
            {
                $appointment->endTran("ROLLBACK");

                echo "error ".$error;
            }
            else
            {
                        /*$columnas="id_citas";
                        $tablas="citas INNER JOIN estados
                                ON citas.id_estados = estados.id_estados";
                        $where="fecha_citas=STR_TO_DATE('".$date."', '%d/%m/%Y') AND hora_citas='".$time."' AND duracion_citas = ".$duration." 
                                AND id_paciente_citas = ".$id_paciente." AND estados.nombre_estados='ACTIVO'";
                        $id="id_citas";
                        $id_citas=$appointment->getCondiciones($columnas, $tablas, $where, $id);

                        $id_citas=$id_citas[0]['id_citas'];*/
                                       
                foreach ($table as $procedures)
                {
                    $query ="";

                    if ($procedures[2]=="")
                    {
                        $columnas="id_procedimientos";
                        $tablas="procedimientos INNER JOIN estados
                        ON procedimientos.id_estado_procedimientos = estados.id_estados";
                        $where="nombre_procedimientos = '".$procedures[1]."' AND estados.nombre_estados='ACTIVO'";
                        $id="id_procedimientos";
                        $id_procedimiento=$appointment->getCondiciones($columnas, $tablas, $where, $id);
                
                        $id_procedimiento=$id_procedimiento[0]['id_procedimientos'];

                        $query = "INSERT INTO extra_procedimientos (id_procedimientos, costo_extra_procedimientos, descuento_extra_procedimientos,
                                                orden_extra_procedimientos, id_citas)
                                VALUES (".$id_procedimiento.",".$procedures[4].",".$procedures[5].",".$procedures[0].",".$id_citas.")";
           
            
                    }
                    else
                    {
                        $columnas="especificaciones_procedimientos.id_procedimientos, especificaciones_procedimientos.id_especificaciones_procedimientos";
                        $tablas="especificaciones_procedimientos INNER JOIN procedimientos 
                                ON especificaciones_procedimientos.id_procedimientos = procedimientos.id_procedimientos";
                        $where="especificaciones_procedimientos.nombre_especificaciones_procedimientos = '".$procedures[2]."' 
                                AND procedimientos.nombre_procedimientos = '".$procedures[1]."'";
                        $id="id_procedimientos";
                        $result_id_procedimiento=$appointment->getCondiciones($columnas, $tablas, $where, $id);

                        $id_procedimiento=$result_id_procedimiento[0]['id_procedimientos'];
                        $id_especificacion_procedimiento=$result_id_procedimiento[0]['id_especificaciones_procedimientos'];

                        $query = "INSERT INTO extra_procedimientos (id_procedimientos, id_especificacion_procedimientos, costo_extra_procedimientos, descuento_extra_procedimientos,
                                                orden_extra_procedimientos, id_citas)
                                VALUES (".$id_procedimiento.", ".$id_especificacion_procedimiento.", ".$procedures[4].",".$procedures[5].",".$procedures[0].",".$id_citas.")";
                    }

                    $resultInsert=$appointment->executeNonQuery($query);
                    $error = error_get_last();

                    if ($resultInsert != "1" || !empty($error))
                        {
                            $appointment->endTran("ROLLBACK");

                            echo "error ";
                            break;
                        }
                }
                $error = error_get_last();

                    if (!empty($error))
                        {
                            $appointment->endTran("ROLLBACK");

                            echo "error";
                        }
                        else
                        {
                            $appointment->endTran("COMMIT");

                            echo "success|".$id_citas;
                        }
            }
        
    }
    
    public function getProcedureType()
    {
        $extras = new ExtrasModel();
        
        $id_procedimiento = $_POST['procedure_id'];
        
        $columnas="tipo_procedimientos.nombre_tipo_procedimientos";
        $tablas="tipo_procedimientos INNER JOIN procedimientos
                 ON tipo_procedimientos.id_tipo_procedimientos = procedimientos.id_tipo_procedimientos";
        $where="procedimientos.id_procedimientos = ".$id_procedimiento;
        $id="tipo_procedimientos.id_tipo_procedimientos";
        $resultSet=$extras->getCondiciones($columnas, $tablas, $where, $id);
        
        echo $resultSet[0]['nombre_tipo_procedimientos'];
    }
    
    public function getProcedureBDCost()
    {
        $extras = new ExtrasModel();
        
        $id_procedimiento = $_POST['procedure_id'];
        
        $columnas="precio_procedimientos, duracion_procedimientos";
        $tablas="procedimientos";
        $where="id_procedimientos = ".$id_procedimiento;
        $id="id_procedimientos";
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