<?php
//框架入口配置文件
defined('IN_MS') or exit('Invalid access!');

header('Content-type: text/html; charset=utf-8');//设置编码
session_start();//启动session取服务器端的缓存

function my_autoload($class_name) {
	$file = FRAMEWORK_PATH.'/libraries/'.$class_name.'.class.php'; 

	if(file_exists($file)){
		require $file; 
	}
 	return ;
}

spl_autoload_register('my_autoload');
// 配置文件
require ROOT_PATH.'/common/conf/config.php';
// 通用函数库
require FRAMEWORK_PATH.'/helpers/base.helper.php';

date_default_timezone_set('PRC');
define('TIMESTAMP',time());
define('CURRENT_URL',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
define('BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']);

function myexception_handler($e){
	echo '<pre>';
	echo $e->getFile().':'.$e->getLine().'<br>';
	echo 'Error:'.$e->getMessage();
    echo '</pre>';
    exit;
}

function myerror_handler($errno, $errstr, $errfile, $errline){
	var_dump($errno,$errstr,$errfile,$errline);
    exit;
}

set_exception_handler('myexception_handler');
//set_error_handler('myerror_handler');

require FRAMEWORK_PATH.'/core/Controller.class.php';// 控制器基类

list($controller,$action) = parse_route();

define('CONTROLLER',$controller);
define('ACTION',$action);

$controller_file = ROOT_PATH.'/'.APP.'/controllers/'.ucfirst($controller).'.php';

if(!file_exists($controller_file)){
	throw new Exception(CONTROLLER."Controller not found", 404);
}

include $controller_file;

$class = ucfirst($controller);

$controller = new $class();

if(!method_exists($controller,$action)){
	throw new Exception(ACTION."Action not found", 404);
}

call_user_func(array($controller,$action));

//调试信息
if(DEBUG && !ajax_request()){
	//d($_SERVER);
	//d($_SESSION);
}else{
	exit();
}

?>