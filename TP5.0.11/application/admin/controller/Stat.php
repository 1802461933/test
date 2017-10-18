<?php 
namespace app\admin\controller;
use think\Request;
class Stat extends Common{
     public function __construct(){
        parent::__construct();
        if(input('session.group_id')<9){
            $this->error('当前没有操作权限');
        }
    }
    
      /*实例化model*/
    public function adminModel(){
        $adminModel = model('Admin');
        return $adminModel;
    }
    
    public function index(){
        return view();
    }
    
    
    public function user(Request $res){
        $y = $res->param('y',date('Y'));
        $m = $res->param('m'); 
        if($m<10 and $m>0 and strlen($m)<2){
            $m = '0'.$m;
        }
        $date = $y.$m; 
        #$where = "p.edittime_str like '".$date."%'";
        $where = "edittime_str like '".$date."%'";
        $list = $this->adminModel()->stat_by_user($where);
        $this->assign('y',$y);
        $this->assign('m',$m);
        $this->assign('list',$list);
        return $this->fetch();

    }
    
    public function menu(){
        for($i=date("Y");$i>=2016;$i--){
            $list[] = $i;
        }
        return view('menu',[
            'list'=>$list
        ]);
    }
    
    public function section(Request $res){
         $y = $res->param('y',date('Y'));
        $m = $res->param('m');
        if($m<10 and $m>0 and strlen($m)<2){
            $m = '0'.$m;
        }
        $date = $y.$m; 
        #$where = "p.edittime_str like '".$date."%'";
        $where = "edittime_str like '".$date."%'";
        $list = $this->adminModel()->stat_by_section($where);
        $this->assign('y',$y);
        $this->assign('m',$m);
        $this->assign('list',$list);
        return $this->fetch();
    }
    
    public function cat(Request $res){
         $y = $res->param('y',date('Y'));
        $m = $res->param('m');
    
        if($m<10 and $m>0 and strlen($m)<2 ){
            $m = '0'.$m;
        }
        $date = $y.$m; 
        $where = "edittime_str like '".$date."%'";
        $list = $this->adminModel()->stat_by_cat($where);
        $this->assign('y',$y);
        $this->assign('m',$m);
        $this->assign('list',$list);
        return $this->fetch();
    }
    
    
    public function userInfo(Request $res){
        $y = $res->param('y',date('Y'));
        $m = $res->param('m');
        $date = $y.$m;
        $id = $res->param('id',0);
        if($id and $date){
          $where = 'user_id='.$id." and edittime_str like '".$date."%'";
          $data = $this->adminModel()->get_stat_user_info($where);
        }else{
            $this->error('参数错误');
        };
        
        return view('userInfo',[
            'data'=>$data['data'],
            'user'=>$data['user'],
            'page'=>$data['page'],
            'y'=>$y,
            'm'=>$m,
            'id'=>$id
        ]);
    }
    
    public function sectionInfo(Request $res){
        $y = $res->param('y',date('Y'));
        $m = $res->param('m');
        $name = $res->param('name');
        $date = $y.$m;
        $id = $res->param('id',0);
        if($id and $date){
          $where = "edittime_str like'".$date."%'";
          $data = $this->adminModel()->get_stat_section_info($where,$id);
        }else{
            $this->error('参数错误');
        };
        
        return view('sectionInfo',[
            'data'=>$data['data'],
            'user'=>$data['user'],
            'page'=>$data['page'],
            'y'=>$y,
            'm'=>$m,
            'id'=>$id,
            'name'=>$name
        ]);
    }
      
    public function catInfo(Request $res){
        $y = $res->param('y',date('Y'));
        $m = $res->param('m');
        $name = $res->param('name');
        $date = $y.$m;
        $id = $res->param('id',0);
        if($id and $date){
          $where = "edittime_str like'".$date."%'";
          $data = $this->adminModel()->get_stat_cat_info($where,$id);
        }else{
            $this->error('参数错误');
        };
        
        return view('catInfo',[
            'data'=>$data['data'],
            'user'=>$data['user'],
            'page'=>$data['page'],
            'y'=>$y,
            'm'=>$m,
            'id'=>$id,
            'name'=>$name
        ]);
    }
    
}

?>