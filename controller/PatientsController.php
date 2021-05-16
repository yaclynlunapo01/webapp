<?php 
class PatientsController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Patients";
        $tabName="Patients";
        
        $this->view("Patients",array("pageName"=>$pageName, "tabName"=>$tabName));
        
    }
    
    public function InsertPatient()
    {
        $patients = new PatientsModel();
        
        $name = $_POST['patient_name'];
        $surname  = $_POST['patient_surname'];
        $patronimic  = $_POST['patient_patronimic'];
        $birthday = $_POST['patient_birthday'];
        $phone = $_POST['patient_phone'];
        $observation = $_POST['patient_observation'];
               
        $columnas="id_pacientes";
        $tablas="pacientes";
        $where="telefon_pacientes='".$phone."'";
        $id="id_pacientes";
        $resultSet=$patients->getCondiciones($columnas, $tablas, $where, $id);
                
        if (empty($resultSet))
        {
            
            $query = "INSERT INTO pacientes (imya_pacientes, familia_pacientes, ochestvo_pacientes, telefon_pacientes, fecha_n_pacientes, observacion_pacientes)
                     VALUES ('".$name."','".$surname."','".$patronimic."','".$phone."','".$birthday."','".$observation."')";
           
            $resultInsert=$patients->executeNonQuery($query);
            
            echo $resultInsert;
        }
        else
        {
            echo "2";
        }
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
                $html.='<th></th>';
                $html.='<th>ФИО</th>';
                $html.='<th>Телефон</th>';
                $html.='<th>Дата Рождения</th>';
                $html.='</tr>';
                $html.='</thead>';
                $html.='<tbody>';
                
                
                $i=0;
                
                foreach ($resultSet as $res)
                {
                    $i++;
                    $html.='<tr>';
                    $html.='<td><button type="button" class="btn btn-light" onclick="seePatient('.$res['id_pacientes'].')"><i class="fa fa-share"></i></button></td>';
                    $html.='<td>'.$i.'</td>';
                    $html.='<td>'.$res['familia_pacientes'].' '.$res['imya_pacientes'].' '.$res['ochestvo_pacientes'].'</td>';
                    $html.='<td>'.$res['telefon_pacientes'].'</td>';
                    $html.='<td>'.$res['fecha_n_pacientes'].'</td>';
                    $html.='</tr>';
                }
                
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section>';
                $html.='</div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_patients("index.php", $page, $total_pages, $adjacents,"loadPatients").'';
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

    public function GetPatientsEditable(){
        
        
        
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
                $html.='<th></th>';
                $html.='<th>ФИО</th>';
                $html.='<th>Телефон</th>';
                $html.='<th>Дата Рождения</th>';
                $html.='</tr>';
                $html.='</thead>';
                $html.='<tbody>';
                
                
                $i=0;
                
                foreach ($resultSet as $res)
                {
                    $i++;
                    $html.='<tr>';
                    $html.='<td><button type="button" class="btn btn-light" onclick="editPatient('.$res['id_pacientes'].')"><i class="fa fa-pencil"></i></button></td>';
                    $html.='<td>'.$i.'</td>';
                    $html.='<td>'.$res['familia_pacientes'].' '.$res['imya_pacientes'].' '.$res['ochestvo_pacientes'].'</td>';
                    $html.='<td>'.$res['telefon_pacientes'].'</td>';
                    $html.='<td>'.$res['fecha_n_pacientes'].'</td>';
                    $html.='</tr>';
                }
                
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section>';
                $html.='</div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_patients("index.php", $page, $total_pages, $adjacents,"loadPatients").'';
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

    public function getPatientInfo()
    {
        $procedures = new ProceduresModel();
        $patient_id =  $_POST['patient_id'];
        
        $columnas="*";
        $tablas="pacientes";
        $where="id_pacientes = ".$patient_id;
        $id="id_pacientes";
        $resultSet=$procedures->getCondiciones($columnas, $tablas, $where, $id);
        
        echo json_encode($resultSet);
    }

    public function UpdatePatient()
    {
        $patients = new ProceduresModel();
        
        $patient_id=$_POST['patient_id'];
        $name = $_POST['patient_name'];
        $surname  = $_POST['patient_surname'];
        $patronimic  = $_POST['patient_patronimic'];
        $birthday = $_POST['patient_birthday'];
        $phone = $_POST['patient_phone'];
        $observation = $_POST['patient_observation'];
               
        $columnas="id_pacientes";
        $tablas="pacientes";
        $where="telefon_pacientes='".$phone."' AND id_pacientes <> ".$patient_id;
        $id="id_pacientes";
        $resultSet=$patients->getCondiciones($columnas, $tablas, $where, $id);
                
        if (empty($resultSet))
        {
            
            $query = "UPDATE pacientes 
                    SET imya_pacientes='".$name."',
                         familia_pacientes='".$surname."',
                         ochestvo_pacientes='".$patronimic."', 
                         telefon_pacientes='".$phone."',
                         fecha_n_pacientes='".$birthday."', 
                         observacion_pacientes='".$observation."'
                    WHERE id_pacientes=".$patient_id;
           
            $resultInsert=$patients->executeNonQuery($query);
            
            echo $resultInsert;
        }
        else
        {
            echo "Телефон уже зарегистрирован!";
        }
                
    }

    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
}
?>