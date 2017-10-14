<?php 
namespace app\admin\controller;
use think\Request;
class Stat extends Common{
     public function __construct(){
        parent::__construct();
        if(input('session.group')<99){
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
    
    public function menu(){
        for($i=date("Y");$i>=2016;$i--){
            $list[] = $i;
        }
        return view('menu',[
            'list'=>$list
        ]);
    }
    
    
}



?>