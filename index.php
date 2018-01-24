<?php
/**
 * 下面来完整的演示采集一篇文章页的文章标题、发布日期和文章内容并实现图片本地化
 */

 //引入自动加载文件
require 'vendor/autoload.php';

use QL\QueryList;
include 'inc_db.php';

/*
//需要采集的目标页面  0-4 [这个demo 指的是固定的节奏url]
for ($i=0; $i<=5; $i++)
{
	$p = 0;
	$page = 'http://cms.querylist.cc/news/56'.$i.'.html';
//采集规则
$reg = [
	//采集文章标题
	'title' => ['h1','text'],
	//采集文章发布日期,这里用到了QueryList的过滤功能，过滤掉span标签和a标签
	'date' => ['.pt_info','text','-span -a',function($content){
		//用回调函数进一步过滤出日期
		$arr = explode(' ',$content);
		return $arr[0];
	}],
	//采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
	'content' => ['.post_content','html','a -.content_copyright -script']
];

$rang = '.content';
$ql = QueryList::get($page)->rules($reg)->range($rang)->query();

$data = $ql->getData(function($item){
	//利用回调函数下载文章中的图片并替换图片路径为本地路径
	//使用本例请确保当前目录下有image文件夹，并有写入权限
	$content = QueryList::html($item['content']);
	$content->find('img')->map(function($img){
		$src = 'http://cms.querylist.cc'.$img->src;
		$localSrc = 'image/'.md5($src).'.jpg';
		$stream = file_get_contents($src);
		file_put_contents($localSrc,$stream);
		$img->attr('src',$localSrc);
	});
	$item['content'] = $content->find('')->html();
	return $item;
});

}

//打印结果
print_r($data->all());

*/





//采集某页面所有的超链接和超链接文本内容
//可以先手动获取要采集的页面源码
$base = "http://www.dytt8.net/";
for ($i=1; $i<=2; $i++) {
	
	$html = file_get_contents('http://www.dytt8.net/html/gndy/dyzz/list_23_'.$i.'.html');
//然后可以把页面源码或者HTML片段传给QueryList
	
	$data = QueryList::html($html)->rules([  //设置采集规则
		// 采集所有a标签的href属性
		'link' => ['.co_content8 b a', 'href'],
		// 采集所有a标签的文本内容
	])->encoding('UTF-8', 'GB2312')->query()->getData();
//打印结果
	
	$result = $data->all();
	
	foreach ($result as $key => $value) {
		$sql = 'INSERT INTO link (link) VALUES ("' . $base . $value['link'] . '")';
		$res = $mysqli->query($sql);
		
	}
}
