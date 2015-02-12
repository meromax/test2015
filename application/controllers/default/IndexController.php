<?php

Zend_Loader::loadClass('System_Controller_Action');

class IndexController extends System_Controller_Action {
	
    public function init() {
        parent::init();
    }

    public function indexAction() {
        $this->smarty->assign('PageBody', 'default/index.tpl');
        $this->smarty->display('index.tpl');
    }


    public function errorPageAction(){
        $this->smarty->assign('PageBody', 'default/error_page.tpl');
        $this->smarty->display('index.tpl');
    }
}