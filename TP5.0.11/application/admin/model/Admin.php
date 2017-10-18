<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
class Admin extends Model
{
    /*������˾id*/
    private $sites;
    
    /*Ϊ��˾id��ֵ*/
    public function __construct(){  
        $this->sites = input('session.site_id');  
    }  
    /*��½�û�����ѯ*/
    public function login($username){
        $data = Db('users')->where('uname',$username)->find();
        return $data;
    }
    
    /*��ȡһ����Ϣ*/
    public function get_find($table,$site_id){
        $data = Db($table)->where('id',$site_id)->find();
        return $data;
    }
    
    /*��ȡ�����б�*/
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
    /*�����Ŀ�б�*/
    public function get_cats_list(){
        $data =  Db('cats')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $data ->render();
        return $list=[
            'data'=>$data,
            'page'=>$page
        ];
    }
    
    /*�Ƚϸ����ֻ��ֶ��Ƿ��ظ�*/
    public function inspect($table,$field,$val){
        $where = [
            $field=>$val,
            'site_id'=>$this->sites
        ];
        $data =  Db($table)->where($where)->find();
        return $data;
    }
    /*�������*/
    public function add($table,$val){
        $data = Db($table)->insert($val);
        return $data;
    }
    
    /*���µ�������*/
    public function mod($table,$mod,$id){
        $data =  Db($table)->where('id',$id)->where('site_id',$this->sites)->update($mod);
        return $data;
    }
    
    /*ɾ��һ������*/
    public function del($table,$id){
        $data =  Db($table)->where('id',$id)->where('site_id',$this->sites)->delete();
        return $data;
    }
    
    /*��ȡ�û���Ϣ�б�*/
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
    
    /*��ȡ�û�������޸�ҳ�沿�������б�ѡ��*/
    public function get_select_list($a){
        $data =Db($a)->where('site_id',$this->sites)->select();
        return $data;
    }
    
    /*��ȡ����ҳ�б�*/
    public function get_section_list(){
        $data = Db('sections')->where('site_id',$this->sites)->order('id desc')->paginate(20,false,['type'=>"BootstrapTwo"]);
        $page = $data->render();
        return $list = [
            'data' => $data,
            'page' => $page
        ];
    }
    
    /*�ж��Ƿ�Ϊ��*/
    public function isNull($table,$where){
        $data = Db($table)->where($where)->field('id')->find();
        return $data;
    }
    
    /*��ȡ��ǰĬ��ý��id*/
    public function get_default_cat_id(){
        $data = Db('cats')->field('id,payment')->where(['status'=>1])->find();
        return $data;
    }
    
    /*����Ĭ��ý��*/
    public function edit_status($id){
        Db('cats')->where('site_id',$this->sites)->update(['status'=>0]);
       $data = Db('cats')->where(['site_id'=>$this->sites,'id'=>$id])->update(['status'=>1]);
       return $data;
    }
    /*��ȡý��ѡ���б�*/
    public function get_cat_list(){
        $data = Db('cats')->where('site_id',$this->sites)->order('status desc')->select();
        return $data;
    }
    
    /*��ȡ��ǰ�Ѿ�Ĭ����ӵ�ý��*/
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
        /*��ѯ���ý��������б�ֻ��ѯ��id��name�ֶ�*/
        $section = Db('sections')->field('id,name')->where('site_id='.$this->sites)->select();
        /*��ѯ���user��������б�ֻ��ѯ��id����������id*/
        $user = Db('users')->field('id,section_id')->where('site_id='.$this->sites .' and group_id = 1 ')->select();
        /*����ͳ�ƺ������µ����ݵ�ͳ��ʱ���Լ���ѯ����ֻ��ѯ���ɺ����õ�����*/
        $where .= ' and site_id='.$this->sites .' and (status=4 or status=-1)';
        /*��ѯ������±�������б�ֻ��ѯý���ֶ��Լ���Ѻ�״̬���������û�id�ֶ�*/
        $post = Db('posts')->where($where)->field('cat_id,status,payment,user_id')->select();
        /*ʹ��ѭ����ѭ������Ϊý�壬ý��ͳ��Ϊ����*/
        foreach($section as $key=>$s){
            /*���û����ݼ�������*/
            foreach($user as $u){
                /*�ж����ݼ�������û�id����ý��id*/
                if($u['section_id']==$s['id']){/*��ô���û����ݼ��е�id��ӵ�$sectuin�������µ��ֶ�users��,��ѭ��һ����ѭ����Σ��ڵ�һ��ѭ���в���id=$section[0]['id']=1,�ڶ���Ϊ����id=$section[1]['id']=2�����ԻὫ�����û�ѭ��һ�ν������û��������ŵ�section_id=id(���idΪ����id)�ͻ�ÿ�ν��û���������id=����id���û�id��ӵ���section[$key(����)]['users']���������*/
                    $section[$key]['users'][]=$u['id'];
                }
            }
           /*�����������*/
            $count_accept = 0;
            /*������������*/
            $count_refuse = 0;
            /*����������*/
            $payment = 0;
            /*ѭ�����в��ɺ����õ�����*/
            foreach($post as $p){
                /*�ж�����$section[$key]['users'](��ǰ$keyΪ��ǰ��������ĵ�ǰ���ŵ�һ�����鼯)��������е��û�id�Ƿ�������������ݼ���*/
                if(in_array($p['user_id'], $section[$key]['users'])){
                    /*���������ô���ڵ�ǰ�����µĸ��û�Ҳ���ڸò�������������status*/
                    if($p['status']==4){
                        /*��������²����������������1��ȡ�ø����µĸ���ۼӸ�ֵ��payment*/
                        $count_accept++;
                        $payment+=$p['payment'];
                    }else{
                        /*�ڸ����ݼ���status״ֻ̬�в��ɺ���������������ǲ�����ôֻʣ������������������ÿ������1*/
                        $count_refuse++;
                    }
                }                
            }
            /*����ѭ����ɺ�ֵ��$section*/
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