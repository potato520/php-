<?php
set_time_limit(0);

//引入自动加载文件
require 'vendor/autoload.php';

use QL\QueryList;
include 'inc_db.php';

//采集某页面所有的超链接和超链接文本内容
//可以先手动获取要采集的页面源码
$base = "http://www.dytt8.net/";
for ($i=1; $i<=168; $i++) {
	
	$html = file_get_contents('http://www.dytt8.net/html/gndy/dyzz/list_23_'.$i.'.html');
//然后可以把页面源码或者HTML片段传给QueryList
	
	$data = QueryList::html($html)->rules([  //设置采集规则
		// 采集所有a标签的href属性
		'link' => ['.co_content8 b a', 'href'],
		// 采集所有a标签的文本内容
	])->encoding('UTF-8', 'GB2312')->query()->getData();
//打印结果
	
	$result = $data->all();
	$root =  dirname(__FILE__) . '/';
	
	foreach ($result as $key => $value) {
		//采集规则
		$reg = [
			'title' => ['.title_all h1 font', 'text'],
			'content' => ['#Zoom', 'html'],
		];
		
		$ql = QueryList::get($base.$value['link'])->rules($reg)
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
}

return 'success..';
