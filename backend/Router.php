<?php

$controller = Zend_Controller_Front::getInstance();
Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
$controller -> setParam('noViewRenderer', true);
$router = $controller -> getRouter();

/********************************************************************************************/
/********************************** INCLUDE MODULES AND ROUTES ******************************/
/********************************************************************************************/

include_once ROOT . 'application/models/System.php';
$routesList = System::dirToArray(ROOT . 'backend/routes');

foreach($routesList as $val){
    $tmpData = explode(".",$val);
    $controller -> addControllerDirectory(ROOT . 'application/controllers/'.$tmpData[0], $tmpData[0]);
    require(ROOT.'backend/routes/'.$val);
}

/** admin module */
//$controller -> addControllerDirectory(ROOT . 'application/controllers/admin', 'admin');

/** Force Zend to throw exceptions */
$controller->throwExceptions(true);


/** Dispatch process */
try {
    $controller -> returnResponse(true);
    $afterDispatching = $controller->dispatch();
    $afterDispatching -> sendResponse();
} catch (Exception $e) {
    //header("location:/error-page.html");
    //echo '<meta http-equiv="Refresh Content="0; URL=/error-page.html">';
    echo $e->getMessage();
}
?>