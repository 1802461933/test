<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
class Admin extends Model
{
    /*声明公司id*/
    private $sites;
    
    /*为公司id赋值*/
    public function __construct(){  
        $this->sites = input('session.site_id');  
    }  
    /*登陆用户名查询*/
    public function login($username){
        $data = Db('users')->where('uname',$username)->find();
        return $data;
    }
    
    /*获取一条信息*/
    public function get_find($table,$site_id){
        $data = Db($table)->where('id',$site_id)->find();
        return $data;
    }
    
    /*获取文章列表*/
    public function get_post_list($status,$key=""){
        $where = 'a.site_id='.$this->sites; 
        if($status){
            $where .= ' and a.status='.$status;
        }
        if($key){
            $where .= " and ( a.title like '%".$key."%' or a.content like '%".$key."%')";
        }
        $data = Db::table('v_posts')->alias('a')->join('v_cats b', 'a.cat_id = b.id','LEFT')->field('a.id,a.title,a.size,a.dateline,a.status,b.name,a.user_id')->where($where)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $data ->render();
        return $list=[
            'data'=>$data,
            'page'=>$page
        ];
    }
    /*获得栏目列表*/
    public function get_cats_list(){
        $data =  Db('cats')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $data ->render();
        return $list=[
            'data'=>$data,
            'page'=>$page
        ];
    }
    
    /*比较该名字或字段是否重复*/
    public function inspect($table,$field,$val){
        $where = [
            $field=>$val,
            'site_id'=>$this->sites
        ];
        $data =  Db($table)->where($where)->find();
        return $data;
    }
    /*添加数据*/
    public function add($table,$val){
        $data = Db($table)->insert($val);
        return $data;
    }
    
    /*更新单条数据*/
    public function mod($table,$mod,$id){
        $data =  Db($table)->where('id',$id)->where('site_id',$this->sites)->update($mod);
        return $data;
    }
    
    /*删除一条数据*/
    public function del($table,$id){
        $data =  Db($table)->where('id',$id)->where('site_id',$this->sites)->delete();
        return $data;
    }
    
    /*获取用户信息列表*/
    public function get_user_list($group){
         if(!$group){
             $data = Db('users')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
            $page = $data->render();
        }else{
            $data = Db('users')->where('group',$group)->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
            $page = $data->render();
        }
        return $list = [
            'data' => $data,
            'page' => $page
        ];
    }
    
    /*获取用户添加与修改页面部门下拉列表选项*/
    public function get_select_list($a){
        $data =Db($a)->where('site_id',$this->sites)->select();
        return $data;
    }
    
    /*获取部门页列表*/
    public function get_section_list(){
        $data = Db('sections')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $data->render();
        return $list = [
            'data' => $data,
            'page' => $page
        ];
    }
    
}
?>