<?php 
class MainPageController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function EventsPage(){
        $pageName="MainPage";
        $tabName="Today";
        $this->view("MainPage",array("pageName"=>$pageName, "tabName"=>$tabName));
        
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

    public function LoadNext()
    {
        $extras = new ExtrasModel();

        $hoy = date("Y-m-d");

        

        $now = date("H:i");
        

        $select="id_citas
        FROM citas INNER JOIN estados
        ON citas.id_estados = estados.id_estados
        WHERE fecha_citas='".$hoy."' AND hora_citas >= '".$now."' AND estados.nombre_estados='ACTIVO'
        ORDER BY hora_citas ASC
        LIMIT 1;";

        $resultSet = $extras->getSelect($select);

        $message="";

        if (!empty($resultSet))
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
            extra_procedimientos.orden_extra_procedimientos";
    $tablas = "citas INNER JOIN estados 
            ON citas.id_estados= estados.id_estados 
            INNER JOIN pacientes 
            ON citas.id_paciente_citas = pacientes.id_pacientes 
            INNER JOIN extra_procedimientos 
            ON extra_procedimientos.id_citas = citas.id_citas";
    $where = "estados.nombre_estados = 'ACTIVO' AND citas.id_citas=".$resultSet[0]['id_citas'];
    $id = "citas.id_citas";

    $info_cita = $extras->getCondiciones($columnas, $tablas, $where, $id);
    $fecha_hoy=$this->getDateFormat($hoy);

    $message = '<strong class="d-inline-block mb-2 text-danger">
    Ближайшая запись 
    <strong class="text-dark col-md-12">'.$info_cita[0]['familia_pacientes'].' '.$info_cita[0]['imya_pacientes'].' '.$info_cita[0]['ochestvo_pacientes'].'
    - '.$fecha_hoy.' - '.$info_cita[0]['hora_citas'].'</strong>
    
    ';
    $message.='<button type="button" class="btn btn-dark float-right" onclick="showAppointment('.$resultSet[0]['id_citas'].')"><i class="fa fa-share"></i></button></strong>';

   
        }
        else
        {
            $message='<strong class="d-inline-block mb-2 text-warning">
            Нет записей 
            </strong>';
        }
        echo $message;
       
    }

    public function LoadToday()
    {
        $appointments = new ExtrasModel();
        
        $hoy = date("Y-m-d");

        $columnas = "citas.id_citas";
        $tablas = "citas INNER JOIN estados 
                    ON citas.id_estados= estados.id_estados";
        $where ="citas.fecha_citas='".$hoy."' AND estados.nombre_estados='ACTIVO'";
        $id = "citas.fecha_citas, citas.hora_citas";

        if(!empty($search_date))
        {
         $where.=" AND citas.fecha_citas ='".$search_date."'";
        }

        $resultSet = $appointments->getCondiciones($columnas, $tablas, $where, $id);

        $html="";

        if (!empty($resultSet))
        {
            foreach ($resultSet as $res)
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
                        extra_procedimientos.orden_extra_procedimientos";
                $tablas = "citas INNER JOIN estados 
                        ON citas.id_estados= estados.id_estados 
                        INNER JOIN pacientes 
                        ON citas.id_paciente_citas = pacientes.id_pacientes 
                        INNER JOIN extra_procedimientos 
                        ON extra_procedimientos.id_citas = citas.id_citas";
                $where = "estados.nombre_estados = 'ACTIVO' AND citas.id_citas=".$res['id_citas'];
                $id = "citas.id_citas";

                $info_cita = $appointments->getCondiciones($columnas, $tablas, $where, $id);
                $fecha = $this->getDateFormat($info_cita[0]['fecha_citas']);
                        
                $html.='<div class="card flex-md-row mb-4 box-shadow h-md-250 bg-light">';
                $html.='<div class="card-body d-flex flex-column align-items-start">';
                $html.='<h3 class="mb-0 col-md-12 text-left">';
                $html.='<strong class="d-inline-block mb-2 text-dark">'.$info_cita[0]['familia_pacientes'].' '
                .$info_cita[0]['imya_pacientes'].' '.$info_cita[0]['ochestvo_pacientes'].'</strong>';
                $html.='<button type="button" class="btn btn-dark float-right" onclick="showAppointment('.$res['id_citas'].')"><i class="fa fa-share"></i></button>';
                $html.='</h3>';
                $html.='<div class="mb-2 text-dark">'.$fecha.' - '.$info_cita[0]['hora_citas'].'</div>';
                $html.='<p class="card-text mb-auto">Примечание к записи:</p>';
                $html.='<p class="card-text mb-auto">'.$info_cita[0]['observacion_citas'].'</p>';
                $html.='<div class="wrapper col-md-12" >';
                $html.='<div class="card" >';
                $html.='<div class="card-header" id="headingOne">';
                $html.='<h3 class="mb-0">';
                $html.='Процедуры';
                $html.='<button class="btn float-right" data-toggle="collapse" data-target="#collapseRegistration'.$res['id_citas'].'" aria-expanded="false" aria-controls="collapseRegistration">';
                $html.='<i class="fa fa-eye fa-lg"></i>';
                $html.='</button>';
                $html.='</h3>';
                $html.='</div>';
                $html.='</div>';
                $html.='<div id="collapseRegistration'.$res['id_citas'].'" class="collapse" aria-labelledby="headingRegistration">';                        
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
            $html.='<h4>Внимание!</h4> <b>Нет больше записей на сегодня</b>';
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