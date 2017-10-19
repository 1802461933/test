<?php 
namespace app\admin\controller;
use think\Request;
class Own extends Common{
     public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    public function index(Request $res){
        $user_info = $this->adminModel()->get_find('users',input('session.user_id'));
        $group = config('user_group');
        $section = $this->adminModel()->get_find('sections',$user_info['section_id']);
        if($res->isPost()){
            $cid = input('post.cid');
            $data = [
                'name' =>input('post.name'),
                'penname'=>input('post.penname'),
                'phone' => input('post.phone','','trim'),
                'email' => input('post.email',',','trim')
            ];
            $request = $this->adminModel()->mod('users',$data,$cid);
            if($request){
                $this->success('修改成功','Own/index');
            }else{
                $this->error('修改失败');
            }
        }
        return view('index',[
            'user_info' => $user_info,
            'group' => $group[$user_info['group_id']],
            'section' => $section['name']
        ]
        );
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
    
    public function psots(Request $request){
        $status = $request->param('status','0','trim');
        $key = $request->param('key','','trim');
        $cat = $this->adminModel()->get_cats_list();
        foreach($cat['data'] as $v){
            $cats[$v['id']]=$v['name'];
        }
        $id = input('session.user_id');
        $data = $this->adminModel()->get_post_list($status,$key,$id);
        $post_status = config("post_status");
        $this->assign('page',$data['page']);
        $this->assign('data',$data['data']);
        $this->assign('cat',$cats);
        $this->assign('user',$data['user']);
        $this->assign('status',$post_status["$status"]);
        $this->assign('key',$key);
        return $this->fetch();
    }
    
}