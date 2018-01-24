<?php
//引入自动加载文件
require 'vendor/autoload.php';

use QL\QueryList;
include 'inc_db.php';

// 获取所有数据
$sql = "SELECT * FROM link";
$res = $mysqli->query($sql);
$nums =  $res->num_rows; //总条数

//防止执行超时
set_time_limit(0);
//清空并关闭输出缓存
ob_end_clean();
//需要循环的数据
foreach ($res as $key => $value)
{
	$i = 1;
	$reg = [
		'title' => ['.title_all h1 font', 'text'],
		'content' => ['#Zoom', 'html'],
	];
	
	$ql = QueryList::get($value['link'])->rules($reg)
		->encoding('UTF-8', 'GB2312')
		->query();
	$data = $ql->getData();
	$arr = $data->all();
	$content = $arr[0]['content'];// 字符实体
	
	$paht = date('Y-m-d',time());
	
	if(!is_dir($paht)){
		mkdir($paht,0777,true);
	}
// 目录名称和文件名
	$file_name = $paht . '/'.rand().'.txt';
	
	$content = file_put_contents($file_name,$content);
	$content2 = file_get_contents($file_name);
	$title = $arr[0]['title'];
	$sql = "INSERT INTO content (content, title) VALUES ('$file_name', '$title')";
	$res = $mysqli->query($sql);
	
	$users[] = 'Tom_' . $i++;
}

//计算数据的长度
$total = count($users);
//显示的进度条长度，单位 px
$width = 500;
//每条记录的操作所占的进度条单位长度
$pix = $width / $total;
//默认开始的进度条百分比
$progress = 0;
?>
<html>
<head>
	<title>动态显示服务器运行程序的进度条</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		body,div input {
			font-family: Tahoma;
			font-size: 9pt
		}
	</style>
	<script language="JavaScript">
        <!--
        function updateProgress(sMsg, iWidth)
        {
            document.getElementById("status").innerHTML = sMsg;
            document.getElementById("progress").style.width = iWidth + "px";
            document.getElementById("percent").innerHTML = parseInt(iWidth / <?php echo $width; ?> * 100) + "%";
        }
        -->
	</script>
</head>
<body>
<div style="margin:50px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: <?php echo $width+8; ?>px">
	<div style="padding: 0; background-color: white; border: 1px solid navy; width: <?php echo $width; ?>px">
		<div id="progress"
			 style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div>
	</div>
	<div id="status"></div>
	<div id="percent"
		 style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">0%</div>
</div>
<?php
flush(); //将输出发送给客户端浏览器
foreach($users as $user)
{
	// 在此处使用空循环模拟较为耗时的操作，实际应用中需将其替换；
	// 如果你的操作不耗时，我想你就没必要使用这个脚本了 :)
	for($i = 0; $i < 1000000; $i++)
	{
	}
	?>
	<script language="JavaScript">
        updateProgress("正在操作用户 <?php echo $user; ?> ....", <?php echo min($width, intval($progress)); ?>);
	</script>
	<?php
	flush(); //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。
	$progress += $pix;
} //end foreach
?>
<script language="JavaScript">
    //最后将进度条设置成最大值 $width，同时显示操作完成
    updateProgress("操作完成！", <?php echo $width; ?>);
</script>
<?php
flush();
?>
</body>
</html>