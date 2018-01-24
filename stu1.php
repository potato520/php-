<?php
/**
 * 发一个GET请求获取数据
 */
header("Content-type: text/html; charset=gb2312");
function get($url)
{
	global $curl;
// 配置curl中的http协议->可配置的荐可以查PHP手册中的curl_
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_HEADER, FALSE);
// 执行这个请求
	return curl_exec($curl);
}

// 生成一个curl对象
$curl = curl_init();

for($i=1;$i<=10;$i++){

	$url = 'http://www.ygdy8.net/html/gndy/dyzz/list_23_'.$i.'.html';
	$data = get($url);
	// 匹配电影所在位置
	$list_preg = '/<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbspan" style="margin-top:6px">.+<\/table>/Us';
	// 匹配img标签上的src和alt
	$video_preg = '/<a href="(.*)" class="ulink">.+<\/a>/U';
	//把所有的li存到$list里，$list是个二维数组
	preg_match_all($list_preg, $data, $list);
	//print_r($list);die;
	foreach ($list[0] as $k => $v) {   //这里$v就是每一个li标签
		preg_match($video_preg, $v, $vide_url);  //把匹配到的图片的信息存到$img里
		//	print_r($vide_url);die;
		echo $vide_url[0];
	}

	
}

	echo "<br><h1>success</h1>";
