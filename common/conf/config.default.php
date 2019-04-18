<?php
!defined('IN_MS') && exit('Invalid Access!');
//数据库配置文件
$conf = array(

	"url_mode"           =>2,//1普通2path模式
	'url_suffix'         =>'.htm',
	'default_controller' =>'site',
	'default_action'     =>'login',
	'db'=>[
		'default'=>[ 
			'host'=>'127.0.0.1', 
			'user'=>'root', 
			'pwd'=>'123456', 
			'charset'=>'utf8', 
			'database'=>'bug',
			'dbpre'=>'t_',
		],
	],
	'upload_url'=>'//dev.bug.com',
);
$conf = array_merge($conf,include APP_PATH.'/config/params.php');

?>
