<?php
require_once('/home/work/www/BeJinXingJK/www/config.php');
class class_mysql
{
    function __construct(){
        $host = DB_HOSTNAME;
        $port = DB_PORT;
        $user = DB_USERNAME;
        $pwd=  DB_PASSWORD;
        $dbname = DB_DATABASE;

        $link = @mysql_connect("{$host}:{$port}", $user, $pwd, true);
        mysql_select_db($dbname, $link);
        return $link;
    }

    //返回数组
    function query_array($sql){
        $result = mysql_query($sql);
        if(!$result){

		 return false;
	}
        $arr = array();
        while ($row = mysql_fetch_assoc($result)){
            $arr[] = $row;
        }
        return $arr;
    }

    //只执行
    function query($sql){
	$query = mysql_query($sql);
	//var_dump($query);
        if (!$query){
            return false;
        }
        return $query;
    }
}
