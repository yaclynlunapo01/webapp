<?php 
class AdminFeedController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function feed(){
        session_start();

        if(isset($_SESSION['id_rol_usuario']) && $_SESSION['id_rol_usuario']==1)
        {
            $pageName="AdminFeed";
        $this->view("AdminFeed",array("pageName"=>$pageName));
        }
        else
        {
            $pageName="NoAccess";
            $this->view("NoAccess",array("pageName"=>$pageName));
        }
        
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

    public function GetConcertFeed()
    {
        $model = new MainModel();

        $html = '';

        $columnas="*";
        $tablas="eventos INNER JOIN tipo_eventos
        ON eventos.id_tipo_evento = tipo_eventos.id_tipo_evento";
        $where="eventos.id_estado_evento=1";
        $id="eventos.fecha_evento";

        $search =  (isset($_POST['search'])&& $_POST['search'] !=NULL)?$_POST['search']:'';
        $type =  (isset($_POST['type'])&& $_POST['type'] !=NULL)?$_POST['type']:'';
        $date =  (isset($_POST['date'])&& $_POST['date'] !=NULL)?$_POST['date']:'';
        
        
        if(!empty($search)){
            
            
            $where1=" AND (eventos.nombre_evento LIKE '".$search."%')";
            
            $where.=$where1;
        }
        
        if(!empty($type)){
            
            $where2=" AND (eventos.id_tipo_evento=".$type.")";
            
            $where.=$where2;
        }
        
        if(!empty($date)){
            
            $where3=" AND (eventos.fecha_evento='".$date."')";
            
            $where.=$where3;
        }
        
        $where_to = $where;

        $resultSet=$model->getCondiciones($columnas, $tablas, $where_to, $id);

        if (!empty($resultSet))
        {
            foreach ($resultSet as $res)
            {
                $tipo_evento ='';
                $fecha_evento = $this->getDateFormat($res['fecha_evento']);
                if ($res['id_tipo_evento']==1) $tipo_evento ='text-success';
                else if ($res['id_tipo_evento']==3) $tipo_evento ='text-primary';
                $html .= '<div class="row mb-2">
                            <div class="col-md-12">
                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                    <div class="card-body d-flex flex-column align-items-start">
                                    <strong class="d-inline-block mb-2 '.$tipo_evento.'">'.$res['nombre_tipo_evento'].'</strong>
                                    <h3 class="mb-0">
                                        <a class="text-dark">'.$res['nombre_evento'].'</a>
                                    </h3>
                                    <div class="mb-1 text-muted">'.$fecha_evento.'</div>
                                        <p class="card-text mb-auto">'.$res['descripcion_evento'].'</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            
        }
        else
        {
            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Внимание!</h4> <b>Нет мероприятий</b>';
            $html.='</div>';
            $html.='</div>';
        }

        echo $html;
    }

    public function SalirSesion()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }    
    
}
?>