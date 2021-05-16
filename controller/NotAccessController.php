<?php 
class NoAccessController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        
        
        $this->view("NoAccess",array());
        
    }
    
}
?>