<?php 
class ComprarBoletoController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function feed(){
        session_start();
        $_SESSION["id_evento"]=$_GET["id_evento"];
        $pageName="ComprarBoleto";
        $this->view("ComprarBoleto",array("pageName"=>$pageName));
        
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

    public function GetConcertInfo()
    {
        session_start();
        $model = new MainModel();        
        $id_evento = $_SESSION["id_evento"];

        $columnas="*";
        $tablas="eventos INNER JOIN tipo_eventos
        ON eventos.id_tipo_evento = tipo_eventos.id_tipo_evento";
        $where="eventos.id_estado_evento=1 AND eventos.id_evento =".$id_evento;
        $id="eventos.fecha_evento";

        $resultSet = $model->getCondiciones($columnas, $tablas, $where, $id);

        $tipo_evento ='';
        $html1='';
        $fecha_evento = $this->getDateFormat($resultSet[0]['fecha_evento']);
        if ($resultSet[0]['id_tipo_evento']==1) 
        {
            $queryA = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=1) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=1))
            AS Diference";

            $price_a ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 1";

            $price_a =$model->enviaquery($price_a);
            $price_a = $price_a[0]["precio_sector"];
            $disponible_a = $model->enviaquery($queryA);

            $queryB = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=2) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=2))
            AS Diference";
            $disponible_b = $model->enviaquery($queryB);

            $price_b ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 2";
            $price_b =$model->enviaquery($price_b);
            $price_b = $price_b[0]["precio_sector"];
            
            $queryC = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=3) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=3))
            AS Diference";
            $disponible_c = $model->enviaquery($queryC);

            $price_c ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 3";
            $price_c =$model->enviaquery($price_c);
            $price_c = $price_c[0]["precio_sector"];

            $queryD = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=4) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=4))
            AS Diference";
            $disponible_d = $model->enviaquery($queryD);

            $price_d ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 4";
            $price_d =$model->enviaquery($price_d);
            $price_d = $price_d[0]["precio_sector"];

            $tipo_evento ='text-success';
            $html1 = '<div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
            <div class="card-body multi-collapse">
              <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3">
                <img src="view/universal/chart_1_top.png" alt="loading" style="width:55%;height:auto;">   
                </div>
                <div class="col-xs-6 col-md-6 col-lg-6 ">
                  <div class="card text-center">
                    <div class="card-header">
                      Трибуна А
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Осталось: '.$disponible_a[0]["Diference"].'</h5>
                        <p class="card-text">Цена : '.$price_a.' руб</p>
                      <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 1)">Выбрать места</button>
                    </div>
                  </div>                
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 ">
                <img src="view/universal/chart_2_top.png" alt="loading" style="width:55%;height:auto;">   
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3">
                <div class="card text-center">
                    <div class="card-header">
                      Трибуна C
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Осталось: '.$disponible_c[0]["Diference"].'</h5>
                        <p class="card-text">Цена : '.$price_c.' руб</p>
                        <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 3)">Выбрать места</button>
                    </div>
                  </div>          
                </div>
                <div class="col-xs-6 col-md-6 col-lg-6 ">
                <img src="view/universal/chart_middle_sport.png" alt="loading" style="width:80%;height:auto;">                  
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 ">
                <div class="card text-center">
                    <div class="card-header">
                      Трибуна D
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Осталось: '.$disponible_d[0]["Diference"].'</h5>
                        <p class="card-text">Цена : '.$price_d.' руб</p>
                        <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 4)">Выбрать места</button>
                    </div>
                  </div>          
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3">
                <img src="view/universal/chart_1_bottom.png" alt="loading" style="width:55%;height:auto;">   
                </div>
                <div class="col-xs-6 col-md-6 col-lg-6 " style ="padding-top:25px;">
                  <div class="card text-center" >
                    <div class="card-header">
                      Трибуна B
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Осталось: '.$disponible_b[0]["Diference"].'</h5>
                    <p class="card-text">Цена : '.$price_b.' руб</p>
                    <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 2)">Выбрать места</button>
                    </div>
                  </div>                
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 ">
                <img src="view/universal/chart_2_bottom.png" alt="loading" style="width:55%;height:auto;">   
                </div>
              </div>
            </div>
          </div>';
        }
        else if ($resultSet[0]['id_tipo_evento']==3) 
        {
            
            $queryA = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=1) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=1))
            AS Diference";

            $price_a ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 1";

            $price_a =$model->enviaquery($price_a);
            $price_a = $price_a[0]["precio_sector"];
            $disponible_a = $model->enviaquery($queryA);
            
            $queryC = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=3) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=3))
            AS Diference";
            $disponible_c = $model->enviaquery($queryC);

            $price_c ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 3";
            $price_c =$model->enviaquery($price_c);
            $price_c = $price_c[0]["precio_sector"];

            $queryD = "SELECT 
            ((SELECT COUNT(id_asientos) FROM asientos WHERE id_sector_asientos=4) -
            (SELECT COUNT(id_boleto) FROM boletos INNER JOIN asientos ON boletos.id_asiento = asientos.id_asientos WHERE boletos.id_eventos = ".$id_evento." AND asientos.id_sector_asientos=4))
            AS Diference";
            $disponible_d = $model->enviaquery($queryD);

            $price_d ="SELECT precio_sector
            FROM sector
            WHERE id_sector = 4";
            $price_d =$model->enviaquery($price_d);
            $price_d = $price_d[0]["precio_sector"];

            $tipo_evento ='text-primary';
            $html1 = '<div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
            <div class="card-body multi-collapse">
              <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3">
                <img src="view/universal/chart_1_top.png" alt="loading" style="width:55%;height:auto;">   
                </div>
                <div class="col-xs-6 col-md-6 col-lg-6 ">
                  <div class="card text-center">
                    <div class="card-header">
                      Трибуна А
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">Осталось: '.$disponible_a[0]["Diference"].'</h5>
                      <p class="card-text">Цена : '.$price_a.' руб</p>
                      <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 1)">Выбрать места</button>
                    </div>
                  </div>                
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 ">
                <img src="view/universal/chart_2_top.png" alt="loading" style="width:55%;height:auto;">   
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3">
                <div class="card text-center">
                    <div class="card-header">
                      Трибуна C
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Осталось: '.$disponible_c[0]["Diference"].'</h5>
                        <p class="card-text">Цена : '.$price_c.' руб</p>
                        <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 3)">Выбрать места</button>
                    </div>
                  </div>          
                </div>
                <div class="col-xs-6 col-md-6 col-lg-6 ">
                <img src="view/universal/chart_middle_concert.png" alt="loading" style="width:80%;height:auto;">                  
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 ">
                <div class="card text-center">
                    <div class="card-header">
                      Трибуна D
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Осталось: '.$disponible_d[0]["Diference"].'</h5>
                        <p class="card-text">Цена : '.$price_d.' руб</p>
                        <button type="button" class="btn btn-primary" onclick="elegirAsientos('.$id_evento.', 4)">Выбрать места</button>
                    </div>
                  </div>          
                </div>
              </div>
          </div>';
        }

        $html ='<div id="collapseTable" class="collapse show" aria-labelledby="headingRegistration">
        <div class="card-body multi-collapse">
          <div class="row">
            <div class="col-xs-6 col-md-3 col-lg-3">
                <h3 class="mb-0">
                <a class="'.$tipo_evento.'">'.$resultSet[0]['nombre_tipo_evento'].'</a>
                </h3>
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 ">
                <h3 class="mb-0">
                <a class="text-dark">'.$resultSet[0]['nombre_evento'].'</a>
                </h3>
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 ">
                <h3 class="mb-0">
                <a class="text-dark">'.$fecha_evento.'</a>
                </h3>               
            </div>
            <div class="col-xs-6 col-md-3 col-lg-3 ">
                <h3 class="mb-0">
                <a class="text-dark">'.$resultSet[0]['hora_evento'].'</a>
                </h3>
            </div>
          </div>
        </div>
      </div>';

      $respuesta = array("cabeza"=>$html, "esquema"=>$html1);

      echo json_encode($respuesta);

    }

       
    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }    
    
}
?>