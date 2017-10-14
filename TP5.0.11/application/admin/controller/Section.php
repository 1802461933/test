<?php
namespace app\admin\controller;
use think\Request;
class Section extends Common{
    /*构造函数初始权限判断*/
    public function __construct(){
        parent::__construct();
        if(input('session.group')<99){
            $this->error('没有访问权限');
        }
    }
    
    /*初始化admin方法*/
    public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    
    /*主页面控制方法*/
    public function index(){
        $list = $this->adminModel()->get_section_list();
        return view('index',[
            'list'=>$list
        ]);
    }
    
    /*侧边栏控制方法*/
    public function menu(){
        return view();
    }
    
    /*添加控制方法*/
    public function add(Request $res){
        if($res->isPost()){
            $name = input('post.name');
            $weight = input('post.weight','10','trim');
            if($name){
                $data = [
                    'site_id'=>input('session.site_id'),
                    'name'=>$name,
                    'weight'=>$weight
                ];
               $request = $this->adminModel()->add('sections',$data);
               if($request){
                   $this->success('添加成功','Section/index');
               }else{
                   $this->error('添加失败');
               }
            }else{
                $this->error('添加错误');
            }
        }
        return view();
    }
    
    public function del(){
        $id = input('get.id');
        if($id){
           $request = $this->adminModel()->del('sections',$id);
            if($request){
                $this->success('删除成功','Section/index');
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('删除失败');
        }
    }
    
    public function mod(Request $res){
        $id = input('get.id');
        $list = $this->adminModel()->get_find('sections',$id);
        if($res->isPost()){
            $name = input('post.name','','trim');
            $weight = input('post.weight','10',"trim");
            if($name){
                $cid = input('post.cid');
                $data = [
                    'name'=>$name,
                    'weight'=>$weight
                ];
                $request = $this->adminModel()->mod('sections',$data,$cid);
                if($request){
                    $this->success('修改成功','Section/index','',1);
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('修改失败');
            }
        }
        return view('mod',[
            'list'=>$list
        ]);
    }
    
}
?>
