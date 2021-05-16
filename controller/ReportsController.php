<?php 
class ReportsController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Reports";
        $this->view("Reports",array("pageName"=>$pageName));
        
    }

    public function GetYears()
    {
        $extras = new ExtrasModel();

        $selec_years="DISTINCT YEAR(fecha_citas) AS anios FROM citas";
        $id_citas=$extras->getSelect($selec_years);

        echo json_encode($id_citas);
    }

    public function GetMonths()
    {
        $year = $_POST['year'];
        $option = array();
        $extras = new ExtrasModel();

        $selec_years="DISTINCT MONTH(fecha_citas) AS mes FROM citas WHERE YEAR(citas.fecha_citas) = ".$year;
        $id_citas=$extras->getSelect($selec_years);

        foreach($id_citas as $meses)
        {
            $mes = $this->getMesFormat($meses['mes']);
            array_push($option,array($mes, $meses['mes']));
        }

        echo json_encode($option);
    }

    public function getMesFormat($date)
    {
         $months = ["",
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
                ];

        $newFormat = $months[(int)$date];

        return $newFormat;
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

    public function GetDay()
    {
        $appointments = new ExtrasModel();

        $date = $_GET['date'];

        $fecha = $this->getDateFormat($date);
        require_once('vendor/autoload.php');

        $mpdf = new \Mpdf\Mpdf([]);

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_left' => 32,
            'margin_right' => 25,
            'margin_top' => 47,
            'margin_bottom' => 47,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);
                       
        $header = '
        <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 15pt; color: #000000;"><tr>
        <td width="50%" align="left"><img src="view/universal/logo_doc.jpeg" width="175px" /></td>
        <td width="50%" style="text-align: center;"><span style="font-weight: bold;">Отчет от '.$fecha.'</span></td>
        </tr></table>';
                
        $footer = '<div align="center">{PAGENO}</div>';
        
        $mpdf->SetHTMLHeader($header);
        
        
        $mpdf->SetHTMLFooter($footer);
        
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
                $where = "estados.nombre_estados = 'PAGADO' AND citas.fecha_citas='".$date."'";
                    
                $id = "extra_procedimientos.id_procedimientos";

                $info_cita = $appointments->getCondiciones($columnas, $tablas, $where, $id);

                if (!empty($info_cita))
                {
                    $html = ''; 
                    $html.='<table>';              
                    $html.='<thead>';
                    $html.='	<tr>';
                    $html.='	<th>Процедура</th>';
                    $html.='	<th>Доп. информация</th>';
                    $html.='	<th>Цена (руб.)</th>';
                    $html.='	<th>Скидка (%)</th>';
                    $html.='	<th>Итог</th>';                                   
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
                        $a_pagar = $precio-$precio*($descuento/100);
                        $total_precio+=$a_pagar;
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
                            $html.='	<td>'.$nombre_proc.'</td>';
                            $html.='	<td>'.$nombre_espc.'</td>';
                            $html.='	<td>'.$cita['costo_extra_procedimientos'].'</td>';
                            $html.='	<td>'.$cita['descuento_extra_procedimientos'].'</td>'; 
                            $html.='	<td>'.$a_pagar.'</td>';                          
                            $html.='	</tr>';
                            
                            
                    }
                    $html.='	<tr>';
                    $html.='	<td><strong>Итог за день :</strong></td>'; 
                    $html.='	<td></td>';
                    $html.='	<td></td>';
                    $html.='	<td></td>';                        
                    $html.='	<td>'.$total_precio.'</td>';                          
                    $html.='	</tr>';
                    $html.='</tbody>';
                    $html.='</table>';
                }
                 else{
                     $html="<h3>НЕТ ДАННЫХ ДЛЯ ЭТОГО ДНЯ!</h3>";
                 } 
                
        $mpdf->WriteHTML($html);
        
       $mpdf->Output();

       
    }
    
    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
}
?>