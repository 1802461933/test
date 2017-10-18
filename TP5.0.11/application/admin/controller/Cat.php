<?php 
namespace app\admin\controller;
use think\Request;
class Cat extends Common{
     public function __construct(){
        parent::__construct();
        if(input('session.group_id')<99){
            $this->error('当前没有操作权限');
        }
    }
    
    /*实例化model*/
    public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    /*右边内容页*/
    public function index(){
        $list = $this->adminModel()->get_cats_list();
        return view('index',[
            'list'=>$list
        ]);
    }
    /*侧边栏方法*/
    public function menu(){
        return view('menu');
    }
    /*添加栏目*/
    public function add(){
        $name = input('post.name',"","trim,addslashes");
        if($name){
            $inspect = $this->adminModel()->inspect('cats','name',$name);
            if(!$inspect){
                $payment = input('post.payment',"","trim,addslashes");
                $data = [
                    'site_id'=>input('session.site_id'),
                    'name'=>$name,
                    'payment'=>$payment
                ];
                $return_value = $this->adminModel()->add('cats',$data);
                if($return_value){
                    $this->success('添加成功','Cat/index');
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->success('该媒体已被注册','Cat/add');
            }
        }
        return view('add');
    }
    
    /*更新栏目*/
    public function mod(){
        $cat_id = input('get.cat_id',"","trim,addslashes");
        $data = $this->adminModel()->get_find('cats',$cat_id);
        $id = input('post.mod_id',"","trim,addslashes");
        if($id){
            $name = input('post.name',"","trim,addslashes");
            $payment = input('post.payment',"","trim,addslashes");
            $data = [
                'name'=>$name,
                'payment'=>$payment
            ];
            $return_value = $this->adminModel()->mod('cats',$data,$id);
            if($return_value){
                $this->success('修改成功','Cat/index');
            }else{
                 $this->error('修改失败');
            }
        }else{
            return view('mod',[
                'data' => $data
            ]);
        }
    }
    
    /*删除栏目*/
    public function del(){
        $id = input('get.cat_id',"","trim,addslashes");
        $ids = ','.$id.',';
        $where = "CONCAT(',',cat_id,',') LIKE '%".$ids."%'";        
        $request_del = $this->adminModel()->isNull('posts',$where);
        $status = $this->adminModel()->get_find('cats',$id);
        if($status['status']==1){
            $this->error('默认媒体不能删除');
        }
        if($request_del){
            $this->error('删除失败:请先清除媒体相关稿件');
        }else{
            $return_value = $this->adminModel()->del('cats',$id);
            if($return_value){
                $this->success('删除成功','Cat/index');
            }else{
                $this->error('删除失败');
            }
        }
    }
    
    
    /*设为默认媒体*/
    public function status(){
      $id = input('get.cat_id');
      $request = $this->adminModel()->edit_status($id);
      if($request){
          $this->success('设置成功','Cat/index');
      }else{
          $this->error('设置失败');
      }
    }
}
?>
