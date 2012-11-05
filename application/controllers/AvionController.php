<?php
 
class ModeleController extends Zend_Controller_Action
{
 
    public function init(){}
 
    public function indexAction(){
        
    }
    
    public function listeAction() {
        $listeAvions = $this->getAllAvions();
    }
    
    public function ajoutAction() {
        
    }
    
    public function modifierAction() {
        
    }
    
    public function supprimerAction() {
        
    }
}