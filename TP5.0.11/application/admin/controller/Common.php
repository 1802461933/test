<?php 
namespace app\admin\controller;
use think\Controller;
class Common extends Controller{
    /*判断登陆*/
    public function __construct(){
        if(!input('session.user_id')){
             $this->success('会话时间已过期请重新登录',"Login/login");
        }
        
    }
    
    public function DeleteHtml($str) 
    { 
        $str = trim($str); 
        $str = strip_tags($str,""); 
        $str = preg_replace("/\t/","",$str); 
        $str = preg_replace("/\r\n/","",$str); 
        $str = preg_replace("/\r/","",$str); 
        $str = preg_replace("/\n/","",$str); 
        $str = preg_replace("/ /"," ",$str); 
        return trim($str); 
    }
}

?>