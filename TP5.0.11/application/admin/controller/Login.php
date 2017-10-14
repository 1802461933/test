<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
class Login extends Controller{
    
     /*返回admin模型*/
    public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    /*登陆方法*/
    public function login(){
        $username = input('post.username',"","trim,addslashes");
        if($username){
            $password = input('post.password',"","trim,md5");
            $data = $this->adminModel()->login($username);
            if($data){
                if($data['password'] === md5($password.$data['salt'])){
                    Session::set('user_id',$data['id']);
                    Session::set('uname',$data['uname']);
                    Session::set('name',$data['name']);
                    Session::set('site_id',$data['site_id']);
                    Session::set('section_id',$data['section_id']);
                    Session::set('group',$data['group']);
                    $sites_data = $this->adminModel()->get_find("sites",$data['site_id']);
                    Session::set('site_name', $sites_data['name']);
                    $this->success('登录成功','Index/index');
                }else{
                    $this->error('密码输入有误');
                }
            }else{
               $this->error('帐号输入错误');
            }
        }
       return view();
    }
    /*注销方法*/
    public function logout(){
        Session::clear();
        $this->success('注销成功',"Login/login");
    }
}
?>