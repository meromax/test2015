<?php

class System
{
    protected $db;
    
    public function __construct() {

    }
    
    public static function setCharset($db) {
    	header('Content-Type: text/html; charset=utf-8');
        return $db -> query('SET NAMES utf8');
    }

    /*
     * Scan directory for files exist
     */
    public static function dirToArray($dirPath) {

        $result = array();

        $cDir = scandir($dirPath);
        foreach ($cDir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dirPath . DIRECTORY_SEPARATOR . $value))
                {
                    $result[$value] = dirToArray($dirPath . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

    public static function smartySetup($templateDirPath='application/views/templates/', $compileDirPath='tmp/templates_c', $pluginDirPath='application/views/plugins'){

        Zend_Loader::loadClass('Zend_Registry');
        require_once LIB_ROOT . 'smarty/Smarty.class.php';
        $Smarty = new Smarty();
        $Smarty -> debugging        = false;
        $Smarty -> force_compile    = true;
        $Smarty -> caching          = false;
        $Smarty -> compile_check    = true;
        $Smarty -> cache_lifetime   = -1;
        $Smarty -> template_dir     = ROOT . $templateDirPath;
        $Smarty -> compile_dir      = ROOT . $compileDirPath;
        $Smarty -> plugins_dir      = array( SMARTY_DIR . 'plugins', ROOT . $pluginDirPath);
        Zend_Registry::set('smarty', $Smarty);

        return Zend_Registry::get('smarty');
    }
}