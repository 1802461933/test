<?php
return [
    'app_debug'              => true,
    'default_module'         => 'admin',
     'database'               => [
        // 数据库类型
        'type'            => 'mysql',
        // 服务器地址
        'hostname'        => '127.0.0.1',
        // 数据库名
        'database'        => 'vote',
        // 数据库用户名
        'username'        => 'root',
        // 数据库密码
        'password'        => 'wd123456',
        // 数据库连接端口
        'hostport'        => '3306',
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => 'v_',
        // 数据库调试模式
        'debug'           => true
    ],
    'SOFTNAMECHINESE'=>"投稿系统",
    'post_status' => [
        '0' => '全部',
        '1' => '草稿',
        '2' => '待审核',
        '3' => '退回待修改',
        '4' => '已发表',
        '-1' => '已弃用'
    ],
    'user_group'=>[
        '1'=>'撰稿人', 
        '9'=>'编辑',
        '99'=>'管理员'
    ]
]
?>