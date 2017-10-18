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
        $user = Db('users')->field('id,name')->where('site_id',$this->sites)->select();
        foreach($user as $val){
            $user_data[$val['id']] = $val['name'];
        };
        $where = 'site_id='.$this->sites; 
        if($status){
            $where .= ' and status='.$status;
        }
        if($key){
            $where .= " and ( title like '%".$key."%' or content like '%".$key."%')";
        }
        if(input('session.group_id')==1){
            $where .= " and user_id=".input('session.user_id');
        }
        if(input('session.group_id')>1){
            $where .= " and status !=". 1;
        }
        $post_data = Db('posts')->where($where)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $post_data ->render();
        return $list=[
            'data'=>$post_data,
            'page'=>$page,
            'user'=>$user_data
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
    public function get_user_list($group_id){
          $section = Db('sections')->where('site_id',$this->sites)->select();
        foreach($section as $val){
            $section_data[$val['id']] = $val['name'];
        };
         if(!$group_id){
             $data = Db('users')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
            $page = $data->render();
        }else{
            $data = Db('users')->where('group_id',$group_id)->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
            $page = $data->render();
        }
        return $list = [
            'data' => $data,
            'page' => $page,
            'section' => $section_data
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
    
    /*判断是否为空*/
    public function isNull($table,$where){
        $data = Db($table)->where($where)->field('id')->find();
        return $data;
    }
    
    /*获取当前默认媒体id*/
    public function get_default_cat_id(){
        $data = Db('cats')->field('id,payment')->where(['status'=>1])->find();
        return $data;
    }
    
    /*设置默认媒体*/
    public function edit_status($id){
        Db('cats')->where('site_id',$this->sites)->update(['status'=>0]);
       $data = Db('cats')->where(['site_id'=>$this->sites,'id'=>$id])->update(['status'=>1]);
       return $data;
    }
    /*获取媒体选择列表*/
    public function get_cat_list(){
        $data = Db('cats')->where('site_id',$this->sites)->order('status desc')->select();
        return $data;
    }
    
    /*获取当前已经默认添加的媒体*/
    public function get_cat_list_id($id){
        $data = Db('posts')->field('cat_id')->where('id',$id)->find();
        $data = explode(',',$data['cat_id']);
        return $data;
    }
    
    public function stat_by_user($where){
        
        $user = Db('users')->field('id,uname,name')->where('site_id='.$this->sites .' and group_id = 1 ')->select();
        $where .= ' and site_id='.$this->sites .' and (status=4 or status=-1)';
        $post = Db('posts')->where($where)->field('cat_id,status,payment,user_id')->select();
        foreach($user as $u){
            $count_accept = 0;
            $count_refuse = 0;
            $payment = 0;
            foreach($post as $p){
                if($u['id']==$p['user_id']){
                    if($p['status']==4){
                        $count_accept++;
                        $payment+=$p['payment'];
                    }else{
                        $count_refuse++;
                    }
                }                
            }
            $users[]=[
                'id'=>$u['id'],
                'name' => $u['name'],
                'count_accept' =>$count_accept,
                'count_refuse' =>$count_refuse,
                'count' =>$count_accept+$count_refuse,
                'payment' =>$payment
            ];
        }
        return $users;
        
    }
    
    public function stat_by_section($where){
        /*查询获得媒体的数据列表，只查询了id与name字段*/
        $section = Db('sections')->field('id,name')->where('site_id='.$this->sites)->select();
        /*查询获得user表的数据列表，只查询了id和所属部门id*/
        $user = Db('users')->field('id,section_id')->where('site_id='.$this->sites .' and group_id = 1 ')->select();
        /*定义统计核心文章的数据的统计时间以及查询条件只查询采纳和弃用的数据*/
        $where .= ' and site_id='.$this->sites .' and (status=4 or status=-1)';
        /*查询获得文章表的数据列表，只查询媒体字段以及稿费和状态，和所属用户id字段*/
        $post = Db('posts')->where($where)->field('cat_id,status,payment,user_id')->select();
        /*使用循环，循环主表为媒体，媒体统计为主表*/
        foreach($section as $key=>$s){
            /*对用户数据集做处理*/
            foreach($user as $u){
                /*判断数据集中如果用户id等于媒体id*/
                if($u['section_id']==$s['id']){/*那么将用户数据集中的id添加到$sectuin数组中新的字段users中,外循环一次内循环多次，在第一次循环中部门id=$section[0]['id']=1,第二次为部门id=$section[1]['id']=2，所以会将所以用户循环一次将其中用户所属部门的section_id=id(这个id为部门id)就会每次将用户所属部门id=部门id的用户id添加到该section[$key(部门)]['users']这个数组中*/
                    $section[$key]['users'][]=$u['id'];
                }
            }
           /*定义采纳总数*/
            $count_accept = 0;
            /*定义弃用总数*/
            $count_refuse = 0;
            /*定义稿费总数*/
            $payment = 0;
            /*循环所有采纳和弃用的文章*/
            foreach($post as $p){
                /*判断数组$section[$key]['users'](当前$key为当前部门数组的当前部门的一个数组集)这个数组中的用户id是否存在与文章数据集中*/
                if(in_array($p['user_id'], $section[$key]['users'])){
                    /*如果存在那么属于当前部门下的该用户也属于该部门则该文章如果status*/
                    if($p['status']==4){
                        /*如果文章呗采纳则采纳总数自增1并取得该文章的稿费累加赋值给payment*/
                        $count_accept++;
                        $payment+=$p['payment'];
                    }else{
                        /*在该数据集中status状态只有采纳和弃用所以如果不是采纳那么只剩下弃用如果有则给弃用每次自增1*/
                        $count_refuse++;
                    }
                }                
            }
            /*单次循环完成后赋值给$section*/
            $sections[]=[
                'id'=>$s['id'],
                'name' => $s['name'],
                'count_accept' =>$count_accept,
                'count_refuse' =>$count_refuse,
                'count' =>$count_accept+$count_refuse,
                'payment' =>$payment
            ];
        }
        return $sections;
    }
    
    public function stat_by_cat($where){
        $cat = Db('cats')->field('id,name')->where('site_id='.$this->sites)->select();
        $where .= ' and site_id='.$this->sites .' and (status=4)';
        $post = Db('posts')->where($where)->field('cat_id,status')->select();
        foreach($cat as $key=>$s){
            $count = 0;
            foreach($post as $p){
                if(strpos('_,'.$p['cat_id'].',' , ','.$s['id'].',')){
                        $count++;
                }                
            }
            $cats[]=[
                'id'=>$s['id'],
                'name' => $s['name'],
                'count' =>$count
            ];
        }
        return $cats;
    }
    
    
    public function get_stat_user_info($where){
        $user = Db('users')->field('id,name')->where('site_id',$this->sites)->select();
        foreach($user as $val){
            $user_data[$val['id']] = $val['name'];
        };
        $where .= " and (status=4 or status=-1) and site_id=".$this->sites;
        $post_data = Db('posts')->where($where)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $post_data ->render();

        return $list=[
            'data'=>$post_data,
            'page'=>$page,
            'user' =>$user_data
        ];
    }
    
    public function get_stat_section_info($where,$id){
        $user = Db('users')->field('id,name')->where( 'site_id',$this->sites)->select();
        $user_where = 'site_id='.$this->sites .' and section_id='.$id.' and group_id=1';
        $in_user = Db('users')->field('id')->where($user_where)->select();
        foreach($user as $val){
            $user_data[$val['id']] = $val['name'];
        };
        $in_users=[];
        foreach($in_user as $key=>$v){
            array_push($in_users,$v['id']); 
        }
        $in = implode(',',$in_users);
        $where .= " and site_id=".$this->sites .' and user_id in ('.$in.') and (status=4 or status=-1)';
        $post_data = Db('posts')->where($where)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $post_data ->render();

        return $list=[
            'data'=>$post_data,
            'page'=>$page,
            'user' =>$user_data
        ];
    }
    
    public function get_stat_cat_info($where,$id){
        $user = Db('users')->field('id,name')->where( 'site_id',$this->sites)->select();
        foreach($user as $val){
            $user_data[$val['id']] = $val['name'];
        };
        
        $where .= " and site_id=".$this->sites .' and status=4'." and CONCAT(',',cat_id,',') LIKE '%".$id."%'";
        $post_data = Db('posts')->where($where)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $post_data ->render();

        return $list=[
            'data'=>$post_data,
            'page'=>$page,
            'user' =>$user_data
        ];
    }
}
?>