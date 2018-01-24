<?php
set_time_limit(0);
//引入自动加载文件
require 'vendor/autoload.php';

use QL\QueryList;
include 'inc_db.php';

$root =  dirname(__FILE__) . '/';

$sql = "SELECT * FROM link";
$res = $mysqli->query($sql);
$nums =  $res->num_rows; //总条数

foreach ($res as $key => $value) {
	$page = $value['link'];
//采集规则
	$reg = [
		'title' => ['.title_all h1 font', 'text'],
		'content' => ['#Zoom', 'html'],
	];
	
	$ql = QueryList::get($page)->rules($reg)
		->encoding('UTF-8', 'GB2312')
		->query();
	$data = $ql->getData();
	$arr = $data->all();
	if(!$arr){
		return 'error';
	}
	$content = $arr[0]['content'];// 字符实体
	
	$paht = date('Y-m-d', time());
	
	if (!is_dir($root.$paht)) {
		mkdir($root.$paht, 0777, true);
	}
// 目录名称和文件名
	$file_name = $root.$paht . '/' . rand() . '.txt';
	
	$content = file_put_contents($file_name, $content);
	$content2 = file_get_contents($file_name);
	$title = $arr[0]['title'];
	$sql = "INSERT INTO content (content, title) VALUES ('$file_name', '$title')";
	$res = $mysqli->query($sql);
	
}

echo 'success';
