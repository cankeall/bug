<?php
/**
 * @todo 
 */
defined('IN_MS') or exit();

class Site extends Controller {

    public function index() {
        exit('no-index');
    }

    public function vcode(){
       $vcode = new Vcode();
       $vcode->doimg();
    }

    // 登录
    public function login(){

        if(!empty($_POST)){
            $username = I('username');
            $pwd = I('password');
            
            $user = DB()->fetch('user',['username'=>$username]);


            if($user->pwd == md6($username,$pwd)){
                if($user->state!=1){
                    message('账号不存在或已禁用',url('site/login') );
                }

                $user->pwd = null;
                $_SESSION['user'] = $user;

                message('登录成功！',url('bug/index') );
            }else{
                message('登录失败',url('site/login') );
            }
        }
        $this->display();
    }

    // 退出
    public function logout(){
        $_SESSION = [];
        session_destroy();
        message('退出成功',url('site/login'));
    }
}
?>
