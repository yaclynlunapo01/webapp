<?php 
class NotFoundController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        
        $this->view("NotFound",array());
        
    }
    
    public function Notfound()
    {
        echo '<script type="text/javascript">',
        'window.location.href = "index.php?controller=NotFound&action=index"',
        '</script>';
    }
    
}
?>