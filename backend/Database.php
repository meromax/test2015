<?php

/** Loading database configuration */
$Config = new Zend_Config_Xml(ROOT . 'configs/database/config.xml', 'database');

/** Making connection via PDO driver */
try {

//    $Db = Zend_Db::factory('pdo_mysql', array('host' => 'baze.best-krepeg.ru.postman.ru:64000',
//        'username' => 'best-krepeg',
//        'password' => 'zo4QU6yWib',
//        'dbname' => 'best-krepeg'));

if(isset($Config -> port)){
    $data = array(
                    'host'     => $Config -> host,
                    'username' => $Config -> username,
                    'password' => $Config -> password,
                    'dbname'   => $Config -> name,
                    'port'     => $Config -> port
                );
} else {
    $data = array(
        'host'     => $Config -> host,
        'username' => $Config -> username,
        'password' => $Config -> password,
        'dbname'   => $Config -> name
    );
}
    $Db = Zend_Db::factory($Config -> type, $data);
    /** Set db connection into registry */
    Zend_Registry::set('db', $Db);
} catch (Exception $e) {
    echo $e->getMessage();
}