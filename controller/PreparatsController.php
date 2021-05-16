<?php 
class PreparatsController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        $pageName="Procedures";
        $tabName="Preparats";
        
        $this->view("Preparats",array("pageName"=>$pageName, "tabName"=>$tabName));
        
    }
    
    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
    
}
?>