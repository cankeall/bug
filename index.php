<?php
/**
 * @码神 Version 1.0 
 */
// 检测PHP环境

define('IN_MS',true);

define('ENVIRONMENT','develop');//develop,test,production

switch(ENVIRONMENT){
	case 'develop':
		define('DEBUG',true);
	    error_reporting(E_ALL &  ~E_NOTICE);
		ini_set('display_errors', 1);
		break;
		
	case 'test':
	case 'product':
		define('DEBUG',false);
		error_reporting(0);
		ini_set('display_errors', 0);
		break;
	default:;
}

define('ROOT_PATH',__DIR__);
define('APP','application');
define('FRAMEWORK_PATH',ROOT_PATH.'/framework');
define('APP_PATH',ROOT_PATH.'/'.APP);

// 引入框架入口文件
require FRAMEWORK_PATH.'/timephp.php';

?>