<?php
/**
 * @todo 
 */
defined('IN_MS') or exit();

class Bug extends Controller {

	private $sid = 0;

	public function __construct(){
		parent::__construct();

		$this->sid = I('sid',1,'intval');
		$this->assign('sid',$this->sid);

	}

    public function index() {
    	$uid = I('uid',0,'intval');
    	$priority = I('priority',0,'intval');
    	$state = I('state',0,'intval');
    	$touid = I('touid',0,'intval');
    	$pageSize = I('pageSize',20,'intval');
        $q = I('q','');

    	$where = 'sid='.$this->sid;
    	if($uid>0)
    		$where .= ' AND uid='.$uid;
    	else if($touid>0)
    		$where .= ' AND touid='.$touid;

    	if($priority>0) $where .= ' AND priority='.$priority;
    	if($state>0)    $where .= ' AND state='.$state;
        if($q)    $where .= " AND title like '%".$q."%'";

    	$count = DB()->count('bug',$where);

    	$pager = new Pager($count,$pageSize);

    	$offset = $pager->offset();

    	$where .= " ORDER BY id DESC LIMIT {$offset},{$pageSize}";
    	$bugs = DB()->result('bug',$where);

    	$pageHtml = $pager->GetPagerContent();

    	$user = DB()->result('user',['state'=>1],'id,username');
    	$this->assign('user',$user);
    	$this->assign('bugs',$bugs);
    	$this->assign('pageHtml',$pageHtml);

    	$this->assign('uid',$uid);
    	$this->assign('priority',$priority);
    	$this->assign('state',$state);
    	$this->assign('touid',$touid);
        $this->assign('q',$q);

        $this->render();
        
    }

    public function add(){
    	if(!empty($_POST)){
            $title = I('title');
            $priority = I('priority');
            $state = I('state');
            $touid = I('touid');
            $content = I('content','','html_filter');

            $data = [
            	'title'=>$title,
            	'content'=>$content,
            	'priority'=>$priority,
            	'state'=>$state,
            	'touid'=>$touid,
            	'sid'=>$this->sid,
            	'uid'=>$this->user->id,
            	'addtime'=>TIMESTAMP,
            	'updatetime'=>TIMESTAMP,
            ];
            $re = DB()->insert('bug',$data);

            if($re)  message('保存成功','/bug/index/sid/'.$this->sid);

    		message('保存失败',CURRENT_URL);
    	}

    	$user = DB()->result('user',['state'=>1],'id,username');

    	$this->assign('user',$user);

    	$this->render();
    }

    public function update(){
    	$id = I('id',0,'intval');
    	if(!empty($_POST)){
            $title = I('title');
            $priority = I('priority');
            $state = I('state');
            $touid = I('touid');
            $content = I('content','','html_filter');

            $data = [
            	'title'=>$title,
            	'content'=>$content,
            	'priority'=>$priority,
            	'state'=>$state,
            	'touid'=>$touid,
            	'sid'=>$this->sid,
            	'updatetime'=>TIMESTAMP
            ];
            $re = DB()->update('bug',$data,['id'=>$id]);

            if($re)  message('保存成功','/bug/index/sid/'.$this->sid);

    		message('保存失败',CURRENT_URL);
    	}

    	$user = DB()->result('user',['state'=>1],'id,username');

    	$model = DB()->fetch('bug',['id'=>$id]);

    	if($model===null)  
    		exit('Invalid!');

    	$this->assign('user',$user);
    	$this->assign('model',$model);

    	$this->render();
    }


    function delete(){
    	$id = I('id',0,'intval');

    	if($this->user->id>5){
    		message('权限不足','/bug/index/sid/'.$this->sid);
    	}

    	$re = DB()->delete('bug',['id'=>$id]);
    	if($re)
    		message('删除成功','/bug/index/sid/'.$this->sid);
    	message('删除失败','/bug/index/sid/'.$this->sid);
    }

    function upload(){
		$dir = 'upload/image/'.date('Ym/d',TIMESTAMP);
		$img = new Image();
		//var_dump($_FILES['file']);exit;
		$info = $img->upload($_FILES['imgFile'],$dir);
		$src = BASE_URL.'/'.$info['path'];
		$data = array(
				'error'=>0,
				'url'=>$src,		
		);
		exit(json_encode($data));
	}

	function view(){
		$id = I('id',0,'intval');
		$model = DB()->fetch('bug',['id'=>$id]);

		if($model==null){
			throw new Exception("内容不存在或已删除", 1001);
		}
		$this->assign('model',$model);
		$user = DB()->result('user',['state'=>1],'id,username');

    	$this->assign('user',$user);
    	$this->render();
	}

}