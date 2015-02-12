<?php

Zend_Loader::loadClass('Zend_Controller_Action');

include_once ROOT . 'application/models/System.php';

class System_Controller_Action extends Zend_Controller_Action
{
    protected $db;
    protected $smarty;
    protected $currFrontTemplatePath = 'application/views/templates/front/default';

    public function init()
    {
        $this -> smarty = System::smartySetup('application/views/templates/front/default/templates');
        $this -> db = Zend_Registry::get('db');
        Zend_Db_Table_Abstract::setDefaultAdapter($this->db);
        System::setCharset($this->db);

        $this -> smarty -> assign('currFrontTemplate', $this->currFrontTemplatePath);

    }

    public function getInstance()
    {
        return $this;
    }

    public function debug($data, $title = '')
    {
        if(!empty($title)){
            $title = '<b style="color: red;">' . $title . '</b>';
        }
        Zend_Debug::dump($data, $title);
    }

}

?>