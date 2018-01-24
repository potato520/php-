<?php
/**
* 发一个GET请求获取数据
*/
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
$url='http://list.youku.com/category/show/c_96_a_%E7%BE%8E%E5%9B%BD_s_1_d_1_p_3.html';
$data=get($url);
// 匹配电影所在位置
$list_preg = '/<li class="yk-col4 mr1">.+<\/li>/Us';
	// 匹配img标签上的src和alt
	$img_preg = '/<img class="quic" _src="(.*)" src="(.*)" alt="(.*)" \/>/U';
	//匹配电影的url
	$video_preg='/<a href="(.*)" title="(.*)" target="(.*)"><\/a>/U';
		//把所有的li存到$list里，$list是个二维数组
		preg_match_all($list_preg,$data,$list);
		//var_dump($list);
		foreach ($list[0] as $k => $v) {   //这里$v就是每一个li标签
		/* 获取图片及电影名称
		preg_match($img_preg,$v,$img);  //把匹配到的图片的信息存到$img里
		var_dump($img);
		*/
		/*获取电影地址
		preg_match($video_preg,$v,$video);  //把匹配到的电影的信息存到$video里
		var_dump($video);
		*/
		preg_match($img_preg,$v,$img);
		preg_match($video_preg,$v,$video);
		echo $img[0].'<a href="'.$video[1].'">'.$video[2].'</a>';
		}