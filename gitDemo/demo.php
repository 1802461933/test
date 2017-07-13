<?php
	header("Content-type:text/html;charset=utf-8");
	/*连接本地数据库 参数格式为 ip地址:端口号,“数据库用户名（账户）”，“数据库密码”*/
        $db = mysql_connect('localhost:3306','root','123456789');

        if (!$db){
            /*连接错误信息*/
            die('数据库连接信息: ' . mysql_error());
        }
      
        /*进入需要操作的数据库*/
        mysql_select_db('apitest',$db);

         /*定义数据库返回的字符编码集，如果不写则会导致查询出来的信息中，中文乱码*/;
        mysql_query('SET NAMES UTF8');

        /*定义执行的sql语句*/
        $sql = "SELECT * FROM user ";

        /*定义变量获取执行后的返回值,函数执行所有组成的sql语句*/
        $result = mysql_query($sql);

        /*定义一个数组接受返回的数据*/
        $data = array();

        /*使用while循环,将mysql_fetch_array获得的数据赋值给$row 然后在赋值给data,方法参数2表示返回关联数组(MYSQL_ASSOC)还是下标数组(MYSQL_NUM)默认返回是二个都有*/
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
            $data[]=$row;
        }
		echo "<pre>";
		var_dump($data);
		echo "<br>";
		var_dump($_POST['data']);
 ?>