<?php 
class HistoriesController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Patients";
        $tabName="Histories";
        
        $this->view("Histories",array("pageName"=>$pageName, "tabName"=>$tabName));

        echo '<script type="text/javascript">',
                'loadPatients()',
                '</script>';
    }
    
    public function getDateFormat($date)
    {
         $months = ["",
                "Января",
                "Февраля",
                "Марта",
                "Апреля",
                "Мая",
                "Июня",
                "Июля",
                "Августа",
                "Сентября",
                "Октября",
                "Ноября",
                "Декабря"
            ];
        
        $elem = explode("-", $date);

        $newFormat = $elem[2]." ".$months[(int)$elem[1]]." ".$elem[0];

        return $newFormat;
    }

    public function LoadSpecificHistory(){
        
        $pageName="Patients";
        $tabName="Histories";

        $this->view("Histories",array("pageName"=>$pageName, "tabName"=>$tabName));

        $id_paciente = $_GET['patient'];

        echo '<script type="text/javascript">',
                'showHistory('.$id_paciente.')',
                '</script>';
        
    }

    public function loadPatientHistory()
    {
        $appointments = new ExtrasModel();

        $patient_id = $_POST['patient_id'];

        $columnas = "imya_pacientes,
                     familia_pacientes,
                     ochestvo_pacientes,
                     telefon_pacientes,
                     fecha_n_pacientes,
                     observacion_pacientes,
                     id_pacientes";        
        $tablas = "pacientes";        
        $where    = "id_pacientes=".$patient_id;        
        $id       = "id_pacientes";

        $res = $appointments->getCondiciones($columnas,$tablas,$where, $id);

        $html_head = "";
        $values=array();

        $fecha = $this->getDateFormat($res[0]['fecha_n_pacientes']);
        $html_head.='<div class="wrapper col-md-12" >';
        $html_head.='<div class="card" >';
        $html_head.='<div class="card-header" id="headingOne">';
        $html_head.='<h3 class="mb-0">';
        $html_head.='<button class="btn" onclick="loadPatients()">';
        $html_head.='<i class="fa fa-close fa-lg"></i>';
        $html_head.='</button>';
        $html_head.= $res[0]['familia_pacientes'].' '.$res[0]['imya_pacientes'].' '.$res[0]['ochestvo_pacientes'];
        $html_head.='<button class="btn float-right" data-toggle="collapse" data-target="#collapsePatient" aria-expanded="false" aria-controls="collapseRegistration">';
        $html_head.='<i class="fa fa-eye fa-lg"></i>';
        $html_head.='</button>';
        $html_head.='</h3>';
        $html_head.='</div>';
        $html_head.='</div>';
        $html_head.='<div id="collapsePatient" class="collapse" aria-labelledby="headingRegistration">';
        $html_head.='<div class="card-body multi-collapse">';
        $html_head.='<div class="col-xs-6 col-md-4 col-lg-4">';
        $html_head.='<p class="card-text mb-auto"><strong>Телефон :</strong>'.$res[0]['telefon_pacientes'].'</p>';
        $html_head.='</div>';
        $html_head.='<div class="col-xs-6 col-md-4 col-lg-4 ">';
        $html_head.='<p class="card-text mb-auto"><strong>Дата рождения :</strong>'.$fecha.'</p>';
        $html_head.='</div>';
        $html_head.='<div class="row">';
        $html_head.='<div class="col-xs-6 col-md-8 col-lg-8 ">';
        $html_head.='<p class="card-text mb-auto"><strong>Примечания :</strong></p>';
        $html_head.='<textarea  type="text" class="form-control" rows="3" maxlength="255" id="patient-observation" value="" readonly>'.$res[0]['observacion_pacientes'].'</textarea>';
        $html_head.='</div>';
        $html_head.='</div>';                    
        $html_head.='</div>';
        $html_head.='</div>';

        $columnas = "citas.id_citas";
        $tablas = "citas INNER JOIN estados 
                    ON citas.id_estados= estados.id_estados";
        $where = "citas.id_paciente_citas=".$res[0]['id_pacientes']." AND (estados.nombre_estados = 'ACTIVO' OR estados.nombre_estados = 'PAGADO')";
        $id = "citas.fecha_citas, citas.hora_citas";
        
        $resultSet = $appointments->getCondiciones($columnas, $tablas, $where, $id);

        $html="";

        if (!empty($resultSet))
        {
            foreach ($resultSet as $res1)
            {
                $columnas = "pacientes.familia_pacientes, 
                        pacientes.imya_pacientes, 
                        pacientes.ochestvo_pacientes, 
                        citas.hora_citas, citas.fecha_citas, 
                        citas.observacion_citas, 
                        extra_procedimientos.id_procedimientos, 
                        extra_procedimientos.id_especificacion_procedimientos, 
                        extra_procedimientos.costo_extra_procedimientos, 
                        extra_procedimientos.descuento_extra_procedimientos, 
                        extra_procedimientos.orden_extra_procedimientos,
                        estados.nombre_estados";
                $tablas = "citas INNER JOIN estados 
                        ON citas.id_estados= estados.id_estados 
                        INNER JOIN pacientes 
                        ON citas.id_paciente_citas = pacientes.id_pacientes 
                        INNER JOIN extra_procedimientos 
                        ON extra_procedimientos.id_citas = citas.id_citas";
                        $where = "(estados.nombre_estados = 'ACTIVO' OR estados.nombre_estados = 'PAGADO') AND citas.id_citas=".$res1['id_citas'];
                    
                
                $id = "citas.fecha_citas";

                $info_cita = $appointments->getCondiciones($columnas, $tablas, $where, $id);
                $fecha = $this->getDateFormat($info_cita[0]['fecha_citas']);
                        
                $html.='<div class="card flex-md-row mb-4 box-shadow h-md-250 bg-light">';
                $html.='<div class="card-body d-flex flex-column align-items-start">';
                $html.='<h3 class="mb-0 col-md-12 text-left">';
                $html.='<strong class="d-inline-block mb-2 text-dark">'.$fecha.' - '.$info_cita[0]['hora_citas'].'</strong>';
                if ($info_cita[0]['nombre_estados'] == 'ACTIVO')
                {
                    $html.='<button type="button" class="btn btn-danger float-right" onclick="cancelAppointment('.$res1['id_citas'].','.$res[0]['id_pacientes'].')"><i class="fa fa-close"></i></button>';
                    $html.='<button type="button" class="btn btn-success float-right" onclick="payAppointment('.$res1['id_citas'].','.$res[0]['id_pacientes'].')"><i class="fa fa-rub"></i></button>';
                }
                $html.='</h3>';
                $html.='<p class="card-text mb-auto">Примечание к записи:</p>';
                $html.='<p class="card-text mb-auto">'.$info_cita[0]['observacion_citas'].'</p>';
                $html.='<div class="wrapper col-md-12" >';
                $html.='<div class="card" >';
                $html.='<div class="card-header" id="headingOne">';
                $html.='<h3 class="mb-0">';
                $html.='Процедуры';
                $html.='<button class="btn float-right" data-toggle="collapse" data-target="#collapseRegistration'.$res1['id_citas'].'" aria-expanded="false" aria-controls="collapseRegistration">';
                $html.='<i class="fa fa-eye fa-lg"></i>';
                $html.='</button>';
                $html.='</h3>';
                $html.='</div>';
                $html.='</div>';
                $html.='<div id="collapseRegistration'.$res1['id_citas'].'" class="collapse" aria-labelledby="headingRegistration">';                        
                $html.='<div class="card-body multi-collapse">';
                $html.='<table id="procedures_table_info" class="table table-bordered">';
                $html.='<thead>';
                $html.='	<tr>';
                $html.='<th></th>';
                $html.='	<th>Процедура</th>';
                $html.='	<th>Доп. информация</th>';
                $html.='	<th>Цена (руб.)</th>';
                $html.='	<th>Скидка (%)</th>';                              
                $html.='	</tr>';		
                $html.='</thead>';
                $html.='<tbody>';
                $total_precio=0.0;
                foreach($info_cita as $cita)
                {
                    $nombre_proc="";
                    $nombre_espc="";
                    $precio = (float)$cita['costo_extra_procedimientos'];
                    $descuento = (float)$cita['descuento_extra_procedimientos'];
                    $total_precio+=$precio-$precio*($descuento/100);
                    if (empty($cita['id_especificacion_procedimientos']))
                        {
                            $columnas="nombre_procedimientos";
                            $tablas="procedimientos";
                            $where="id_procedimientos = ".$cita['id_procedimientos'];
                            $id="id_procedimientos";
                            $id_procedimiento=$appointments->getCondiciones($columnas, $tablas, $where, $id);
                    
                            $nombre_proc=$id_procedimiento[0]['nombre_procedimientos'];
                            
                        }
                        else
                        {
                            $columnas="procedimientos.nombre_procedimientos, especificaciones_procedimientos.nombre_especificaciones_procedimientos";
                            $tablas="especificaciones_procedimientos INNER JOIN procedimientos 
                                    ON especificaciones_procedimientos.id_procedimientos = procedimientos.id_procedimientos";
                            $where="especificaciones_procedimientos.id_especificaciones_procedimientos = ".$cita['id_especificacion_procedimientos'];
                            $id="procedimientos.id_procedimientos";
                            $result_id_procedimiento=$appointments->getCondiciones($columnas, $tablas, $where, $id);

                            $nombre_proc=$result_id_procedimiento[0]['nombre_procedimientos'];
                            $nombre_espc=$result_id_procedimiento[0]['nombre_especificaciones_procedimientos'];

                        }
                        $html.='	<tr>';
                        $html.='<td>'.$cita['orden_extra_procedimientos'].'</td>';
                        $html.='	<td>'.$nombre_proc.'</td>';
                        $html.='	<td>'.$nombre_espc.'</td>';
                        $html.='	<td>'.$cita['costo_extra_procedimientos'].'</td>';
                        $html.='	<td>'.$cita['descuento_extra_procedimientos'].'</td>';                           
                        $html.='	</tr>';
                }
                $html.='</tbody>';
                $html.='</table>';                         
                $html.='</div>';
                $html.='</div>';

                $html.='<h3 class="mb-0">';
                $html.='<strong class="d-inline-block mb-2 text-dark">Итого: '.$total_precio.' руб.</strong>';
                $html.='</h3>';
                //cierre de la card
                $html.='</div>';
                $html.='</div>';
                $html.='</div>';
            }
        }
        else
        {
        
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Внимание!</h4> <b> У пациента нет записей</b>';
            $html.='</div>';
            $html.='</div>';
            
        }
        
        array_push($values,$html_head,$html);

        echo json_encode($values);

    }

    public function loadPatients()
    {
        $appointments = new ExtrasModel();
        
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

        $resultSet = $appointments->getCondiciones($columnas, $tablas, $where_to, $id);

        $html="";

        if (!empty($resultSet))
        {
            foreach($resultSet as $res)
            {
                $fecha = $this->getDateFormat($res['fecha_n_pacientes']);
                $html.='<div class="card flex-md-row mb-4 box-shadow h-md-250 bg-light">';
                $html.='<div class="card-body d-flex flex-column align-items-start">';
                $html.='<h3 class="mb-0 col-md-12 text-left">';
                $html.='<strong class="d-inline-block mb-2 text-dark">'.$res['familia_pacientes'].' '
                .$res['imya_pacientes'].' '.$res['ochestvo_pacientes'].'</strong>';   
                $html.='<button type="button" class="btn btn-dark float-right" onclick="showHistory('.$res['id_pacientes'].')"><i class="fa fa-share"></i></button>';
                $html.='</h3>';
                $html.='<div class="mb-2 text-dark">Дата рождения: '.$fecha.'</div>';
                $html.='<div class="mb-2 text-dark">Телефон: '.$res['telefon_pacientes'].'</div>';
               
                //cierre de la card
                $html.='</div>';
                $html.='</div>';
                $html.='</div>';
            }
        }
        else
        {
        
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Внимание!</h4> <b>Нет результатов по вашему запросу</b>';
            $html.='</div>';
            $html.='</div>';
            
        }
        echo $html;
   
    }

    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
    
}
?>