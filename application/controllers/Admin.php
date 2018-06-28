<?php
/**
 * @todo 
 */
defined('IN_MS') or exit();

class Admin extends Controller {

    public function index(){

        $pageSize = I('pageSize',10,'intval');
        $q = I('q','');

        $where = '1=1';
        if($q)    $where .= " AND username like '%".$q."%'";

        $count = DB()->count('admin',$where);

        $pager = new Pager($count,$pageSize);

        $offset = $pager->offset();

        $where .= " ORDER BY id DESC LIMIT {$offset},{$pageSize}";
        $rows = DB()->result('admin',$where);

        $pageHtml = $pager->GetPagerContent();


        $this->assign('rows',$rows);
        $this->assign('pageHtml',$pageHtml);
        $this->assign('q',$q);

        $this->render();
    }

    public function add() {
    	if(!empty($_POST)){

            $username = I('username');
            $pwd = I('pwd');

            if(empty($username)){
            	message('账号不能为空',url('admin/add'));
            }
            if(empty($pwd)){
            	message('密码不能为空',url('admin/add'));
            }

            $model = DB()->fetch('admin',array('username'=>$username));
            // d(DB()->sqls);
            if($model){
	            $msg =  '用户名'.$username.'已存在';
	            message($msg,url('admin/add'));
	        }else{
            	$data = [
	            	'username'=>$username,
	            	'pwd'=>md6($username,$pwd),
	            	'state'=>1,
            	];
        		$re = DB()->insert('admin',$data);
            
            	if($re){
                	message('添加成功',url('admin/index'));
                }else{
                	message('添加失败',url('admin/add'));
                }
            }
        }
        $this->render();
    }

    public function update() {
        $id = I('id',0,'intval');
        $model = DB()->fetch('admin',['id'=>$id]);

        if(!empty($_POST)){

            $pwd = I('pwd');
            $state = I('state',0,'intval');

            $data = [
                'state'=>$state,
            ];
            if(!empty($pwd)){
                $data['pwd'] = md6($model->username,$pwd);
            }
            $re = DB()->update('admin',$data,['id'=>$id]);
        
            if($re){
                message('修改成功',url('admin/update',['id'=>$id]));
            }else{
                message('修改失败',url('admin/update',['id'=>$id]));
            }

        }
        
        if($model===null){
            message('不存在',url('admin/index'));
        }

        $this->assign('model',$model);
        $this->render();
    }

    function delete(){
        $id = I('id',0,'intval');
        $re = DB()->delete('admin',['id'=>$id]);
        if($re){
            message('删除成功',url('admin/index'));
        }
        message('删除失败',url('admin/index'));
    }
}