<?php

include_once ROOT . 'application/models/UsersDb.php';

Zend_Loader::loadClass('System_Controller_Action');

class Users_IndexController extends System_Controller_Action
{
    protected $users;
    public function init() {
        parent::init();

        $this->users = new UsersDb();
    }

    public function indexAction() {
        echo json_encode($this->users->getUsers());
    }

    public function defaultAction() {
        echo json_encode($this->users->getUsers());
    }

    public function filterAction() {
        $ids = $this->_getParam('ids');
        $items = $this->users->getUsersByFilter($ids);

        $res['success']=true;
        $res['msg']='execute success!';
        $res['items']=$items;
        echo json_encode($res);
    }

    public function educationAction(){
        $items = $this->users->getEducation();
        echo json_encode($items);
    }

    public function getCheckCitiesAction(){
        $items = $this->users->getCities();
        $checksArray = array();

        foreach($items as $key=>$val){
            $checksArray['root'][$key]['xtype'] = 'checkbox';
            $checksArray['root'][$key]['boxLabel'] = $val['title'];
            $checksArray['root'][$key]['name'] = $val['title'];
            $checksArray['root'][$key]['inputValue'] = $val['title'];
        }

        $res['success']=true;
        $res['msg']='execute success!';
        $res['items']=$items;

        echo json_encode($res);
    }

    public function getCheckEducationsAction(){
        $items = $this->users->getEducation();
        $res['success']=true;
        $res['msg']='execute success!';
        $res['items']=$items;
        echo json_encode($res);
    }

    public function saveEducationAction(){
        $userID = $this->_getParam('userID');
        $educationID = $this->_getParam('educationID');
        $this->users->updateEducation($userID, $educationID);
        $res['success']=true;
        $res['msg']= 'execute success!';
        $res['items']= $this->users->getUsers();
        echo json_encode($res);
    }

}