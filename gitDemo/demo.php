<?php
	header("Content-type:text/html;charset=utf-8");
	/*���ӱ������ݿ� ������ʽΪ ip��ַ:�˿ں�,�����ݿ��û������˻������������ݿ����롱*/
        $db = mysql_connect('localhost:3306','root','123456789');

        if (!$db){
            /*���Ӵ�����Ϣ*/
            die('���ݿ�������Ϣ: ' . mysql_error());
        }
      
        /*������Ҫ���������ݿ�*/
        mysql_select_db('apitest',$db);

         /*�������ݿⷵ�ص��ַ����뼯�������д��ᵼ�²�ѯ��������Ϣ�У���������*/;
        mysql_query('SET NAMES UTF8');

        /*����ִ�е�sql���*/
        $sql = "SELECT * FROM user ";

        /*���������ȡִ�к�ķ���ֵ,����ִ��������ɵ�sql���*/
        $result = mysql_query($sql);

        /*����һ��������ܷ��ص�����*/
        $data = array();

        /*ʹ��whileѭ��,��mysql_fetch_array��õ����ݸ�ֵ��$row Ȼ���ڸ�ֵ��data,��������2��ʾ���ع�������(MYSQL_ASSOC)�����±�����(MYSQL_NUM)Ĭ�Ϸ����Ƕ�������*/
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
            $data[]=$row;
        }
		echo "<pre>";
		var_dump($data);
		echo "<br>";
		var_dump($_POST['data']);
 ?>