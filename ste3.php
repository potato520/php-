<?php
 
   if($_GET['id']<=8&&$_GET['id']){
	   $id=$_GET['id'];
	   $conn=file_get_contents("https://www.helloweba.net/php/221.html");//获取页面内容
	
	   $pattern="/<div class='blog_title'><h2>\"(.*)\"</h2>";//正则
	
	   preg_match_all($pattern, $conn, $arr);//匹配内容到arr数组
	
	
	   foreach ($arr[1] as $key => $value) {//二维数组[2]对应id和[1]刚好一样,利用起key
		   $url="http://www.93moli.com/".$arr[2][$key];
		   $sql="insert into list(title,url) value ('$value', '$url')";
		   mysql_query($sql);
		
		   //echo "<a href='content.php?url=http://www.93moli.com/$url'>$value</a>"."<br/>";
	   }
	   $id++;
	   echo "正在采集URL数据列表$id...请稍后...";
	   echo "<script>window.location='list.php?id=$id'</script>";
	
   }else{
	   echo "采集数据结束。";
   }
 
?>