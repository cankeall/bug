<?php
//框架控制器文件
defined('IN_MS') or exit();
class Controller {

	protected $_vars = array();
	
	protected $layout = "main";
	protected $user = null;

	function __construct() {

	    if(!isset($_SESSION)){
	        session_start();
        }

        if(empty($_SESSION['user'])){
	        if(CONTROLLER !="site"){
                message("请登录！",url("site/login"));
            }
        }else{
            $this->user = $_SESSION['user'];
        } 
	}

	/**
	 * [renderPartial description]
	 * @param  [type] $route [description]
	 * @param  [type] $vars  [description]
	 * @return [type]        [description]
	 */
	protected function renderPartial($route,$vars){

	}


	/**
	 * [render description]
	 * @param  [type] $route [description]
	 * @return [type]        [description]
	 */
	public function render($route=null){

		if ($this->_vars) {
			extract($this->_vars);//数组转成变量
		}
        
        if(!$route){
			$route = CONTROLLER.'/'.ACTION;
        }

        $template = ROOT_PATH.'/'.APP.'/views/'.$route.'.php';
		
		ob_start();
		include $template;
		$content = ob_get_contents();
		ob_clean();

        //include $this->layout;
        include ROOT_PATH.'/'.APP.'/views/layout/'.$this->layout.'.php';

	}

	/**
	 * [display description]
	 * @param  [type] $route [description]
	 * @return [type]        [description]
	 */
	public function display($route=null){

		if ($this->_vars) {
			extract($this->_vars);//数组转成变量
		}

        if($route){
			$template = ROOT_PATH.'/'.APP.'/views/'.$route.'.php';
        }else {
        	$template =  ROOT_PATH.'/'.APP.'/views/'.CONTROLLER.'/'.ACTION.'.php';
        }

        include $template;

	}

	/** 
	* @todo 解析模板变量
	* @param string $name
	* @param string $value
	*/
	protected function assign($name,$value) {
		$this->_vars[$name] = $value;
	}


	protected function getGames($cateid=1){

		$where = '1=1';
        if($cateid) $where = 'cateid='.$cateid;
        $games = DB()->result('game',$where,'id,name');
        return $games;

	}

	protected function addCashLog($uid,$money,$type,$cateid,$balance=0,$txt=''){
        $data = [
                'uid'=>$uid,
	            'money'=>$money,
	            'type'=>$type,
	            'cateid'=>$cateid,
	            'balance'=>$balance,
	            'txt'=>$txt,
	            'addtime'=>TIMESTAMP,
	    ];
	    $re = DB()->insert('cash_log',$data);
	    return $re;
	}
}
?>