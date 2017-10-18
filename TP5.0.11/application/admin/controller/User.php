<?php 
namespace app\admin\controller;
use think\Request;
class User extends Common{
    public function __construct(){
        parent::__construct();
        if(input('session.group_id')<99){
            $this->error('当前没有操作权限');
        }
    }
    
    /*初始化模块admin*/
    public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    
    /*内容页控制器*/
    public function index(Request $res){
        //dump($this);
        $group_id =$res->param('group_id','0','trim');
        $data = $this->adminModel()->get_user_list($group_id);
        $this->assign('page',$data['page']);
        $this->assign('data',$data['data']);
        $this->assign('section',$data['section']);
        $this->assign('group_id',$group_id);
        return $this->fetch();
    }
    
    /*侧边栏控制器*/
    public function menu(){
        $data = config('user_group');
        return view('menu',[
            'list'=>$data
        ]);
    }
    /*添加用户*/
    public function add(Request $res){
        $select_list = $this->adminModel()->get_select_list('sections');
        $group_list = config('user_group');
        if($res->isPost()){
            $uname = input('post.username','','trim');
            $rel_duplicate_uname = $this->adminModel()->login($uname);
            $password = input('post.password','','md5,trim');
            if($rel_duplicate_uname or (!$uname and !$password)){
                $this->error('填写错误');
            }else{
                $salt = rand(1000,9999);
                $data = [
                    'site_id' => input('session.site_id'),
                    'section_id' => input('post.section','1','trim'),
                    'salt' => $salt,
                    'uname' => $uname,
                    'password' => md5($password.$salt),
                    'name' => input('post.name','','trim'),
                    'penname' => input('post.penName','','trim'),
                    'group_id' => input('post.group_id','1','trim'),
                    'dateline' => time()
                ]; 
                $request = $this->adminModel()->add('users',$data);
                if($request){
                    $this->success('添加成功','User/index');
                }else{
                    $this->error('添加失败');
                }
               
            }
        
        }
          return view('add',[
              'select_list'=>$select_list,
              'group_list' => $group_list
          ]);
    }
    
    public function del(){
        $id = input('get.id');
        $where = 'user_id='.$id.' or editor_id='.$id;        
        $request_del = $this->adminModel()->isNull('posts',$where);
        if($request_del){
            $this->error('删除失败:请先清除用户相关稿件');
        }else{
            $request = $this->adminModel()->del('users',$id);
            if($request){
                $this->success('删除成功','User/index');
            }else{
                $this->error('删除失败');
            }
        }
        
       
    }
    
    public function mod(Request $res){
        $id = input('get.id');
        $user_info = $this->adminModel()->get_find('users',$id);
        $select_list = $this->adminModel()->get_select_list('sections');
        $group_list = config('user_group');
        if($res->isPost()){
            $cid = input('post.cid');
            $data = [
                'uname'=> input('post.uname'),
                'name' =>input('post.name'),
                'penname'=>input('post.penname'),
                'group_id'=>input('post.group_id'),
                'section_id'=>input('post.section')
            ];
            $request = $this->adminModel()->mod('users',$data,$cid);
            if($request){
                $this->success('修改成功','User/index');
            }else{
                $this->error('修改失败');
            }
        }
        return view('mod',[
            'select_list'=>$select_list,
            'user_info' => $user_info,
            'group_list' => $group_list
        ]);
    }
    
    public function modPassword(Request $res){
        $id = input('get.id');
        if($res->isPost()){
            $password = input('post.password','','trim,md5');
            if($password){
                $cid = input('post.cid');
                $salt = rand(1000,9999);
                $new_password = md5($password.$salt);
                $data = [
                    'salt' => $salt,
                    'password' => $new_password
                ];
                $request = $this->adminModel()->mod('users',$data,$cid);
                if($request){
                    $this->success('修改成功','User/index');
                }
            }else{
                $this->error('修改失败');
            }
        }
        return view('modPassword',[
            'cid'=>$id
        ]);
    }
    

}

?>