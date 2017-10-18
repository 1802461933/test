<?php 
namespace app\admin\controller;
use think\Request;
class Own extends Common{
     public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    public function index(){
        return view();
    }
    
    public function password(Request $res){
         $id = input('session.user_id');
         if($res->isPost()){
             $password = input('post.password','','trim,md5');
             if($password){
                 $user_info = $this->adminModel()->get_find('users',$id);
                 if(md5($password.$user_info['salt'])==$user_info['password']){
                     $new_password = input('post.new_password','','trim,md5');
                     if($new_password){
                         $salt = rand(1000,9999);
                         $true_password = md5($new_password.$salt);
                        $data = [
                            'salt' => $salt,
                            'password' => $true_password
                        ];
                        $request = $this->adminModel()->mod('users',$data,$id);
                        if($request){
                            $this->success('修改成功','Own/index');
                        }else{
                            $this->error('修改失败');
                        }
                     }else{
                         $this->error('新密码不能为空');
                     } 
                 }else{
                     $this->error('修改失败');
                 }
             }else{
                     $this->error('修改失败');
            }
         }
         return view();
     }
     
     
     public function menu(){
        return view();
    }
}