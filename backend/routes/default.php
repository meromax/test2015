<?php

$Default = new Zend_Controller_Router_Route_Regex(
    'index.html',
    array('module' => 'default', 'controller' => 'index', 'action' => 'index')
);
$router -> addRoute('Default', $Default);

$ErrorPage = new Zend_Controller_Router_Route_Regex(
    'error-page.html',
    array('module' => 'default', 'controller' => 'index', 'action' => 'error-page')
);
$router -> addRoute('ErrorPage', $ErrorPage);