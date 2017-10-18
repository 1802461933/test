<?php 
namespace app\admin\controller;
use think\Request;
class Post extends Common{
    /*实例化model*/
     public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    /*右边内容页方法*/
    public function index(Request $request){
        $status = $request->param('status','0','trim');
        $key = $request->param('key','','trim');
        $data = $this->adminModel()->get_post_list($status,$key);
        $post_status = config("post_status");
        $this->assign('page',$data['page']);
        $this->assign('data',$data['data']);
        $this->assign('user',$data['user']);
        $this->assign('status',$post_status["$status"]);
        $this->assign('key',$key);
        return $this->fetch();
    }
    /*侧边栏方法*/
    public function menu(){
        $data = config('post_status');
        return view('menu',[
            'list' =>$data
        ]);
    }
    
    /*添加文章方法*/
    public function add(Request $res){
        $select_cat = $this->adminModel()->get_select_list('cats');
        if($res->isPost()){
            $common = controller('Common');
            
            $data = [
                'site_id' => input('session.site_id'),
                'user_id' => input('session.user_id'),
                'title' => input('post.title'),
                'content' => input('post.content'),
                'note' => input('post.note'),
                'size' => mb_strlen($common->DeleteHtml(input('post.content')),'utf-8'),
                'dateline' => time(),
                'status' => input('post.ok')
            ];
            $request = $this->adminModel()->add('posts',$data);
            if($request){
                $this->success('添加成功','Post/index');
            }else{
                $this->error('添加失败');
            }
        }
        return view('add',[
            'select_cat'=>$select_cat
        ]);
    }
    
    /*修改文章*/
    public function mod(Request $res){
        $id = input('get.id');
        $post_info = $this->adminModel()->get_find('posts',$id);
        $common = controller('Common');
        if($res->isPost()){
            $cid = input('post.cid');
            $data = [
                'title' => input('post.title'),
                'content' => input('post.content'),
                'note' => input('post.note'),
                'size' => mb_strlen($common->DeleteHtml(input('post.content')),'utf-8'),
                'status' => input('post.ok')
            ];
            $request = $this->adminModel()->mod('posts',$data,$cid);
            if($request){
                $this->success('修改成功','Post/index');
            }else{
                $this->error('修改失败');
            }
        }
        return view('mod',[
            'post_info'=>$post_info
        ]);
    }
    
    /*删除文章*/
    public function del(){
        $id = input('get.id');
        $request = $this->adminModel()->del('posts',$id);
        if($request){
            $this->success('删除成功','Post/index');
        }else{
            $this->error('删除失败');
        } 
       
    }
    
    public function status(Request $res){
        $id = input('get.id');
        $post_info = $this->adminModel()->get_find('posts',$id);
        if($res->isPost()){
            $cid = input('post.cid');
            $data = [
                'cat_id'=>'',
                'status'=>input('post.status'),
                'memo' => input('post.memo'),
                'edittime'=>time(),
                'edittime_str'=>date('YmdHis'),
                'payment' => 0
            ];
            if(input('post.status')==4){
                $cat = $this->adminModel()->get_default_cat_id();
                if($cat){                    
                    $data['cat_id'] = $cat['id'];
                    $data['payment'] = $cat['payment'];
                }else{
                    $this->error('没有默认媒体');
                }
            }
            $request = $this->adminModel()->mod('posts',$data,$cid);
            if($request){
                $this->success('审批成功','Post/index');
            }else{
                $this->error('审批失败');
            }
            
        }
        return view('status',[
            'post_info' => $post_info
        ]);
    }   
    
    public function addCat(Request $res){
        $id = input('get.id');
        $data = $this->adminModel()->get_cat_list();
        $cat_list_id = $this->adminModel()->get_cat_list_id($id);
        if($res->isPost()){
            $cid = input('post.cid'); 
            $cat_id =input('post.cat_id/a');
            $payment = 0;
            foreach($data as $v){
                if(in_array($v['id'],$cat_id) and $v['payment']>$payment){
                    $payment = $v['payment'];
                };
            }
            dump($payment);
            $submit = [
              'cat_id'=>$cat_id,
              'payment'=>$payment
            ];
            $request = $this->adminModel()->mod('posts',$submit,$cid);
            if($request){
                $this->success('添加成功','Post/index');
            }else{
                $this->error('添加失败');
            }
        }
        return view('addCat',[
            'list'=>$data,
            'cid'=>$id,
            'cat_list_id'=>$cat_list_id
        ]);
    }    
    
    
}
?>