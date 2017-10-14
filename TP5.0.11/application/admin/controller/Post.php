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
        return view('index',[
            'status' => $post_status["$status"],
            'list' => $data,
            'key' => $key
        ]);
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
                'cat_id' => input('post.cat'),
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
    public function mod(){
        return view('mod');
    }
    
    /*删除文章*/
    public function del(){
        
    }
}
?>