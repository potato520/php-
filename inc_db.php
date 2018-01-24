<?php
/**
 * Created by PhpStorm.
 * User: youkaili
 * Date: 2018/1/18
 * Time: 12:07
 */
//mysqli 操作数据（面向对象风格）

#1、创建Mysql对象

$mysqli=new mysqli("127.0.0.1","root","root","pachong");
if(!$mysqli)
{
	die("连接失败！".$mysqli->connect_error);
}

#2、操作数据库

#3、处理结果




?>