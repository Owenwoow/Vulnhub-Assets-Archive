<?php
// 启动/恢复 Session 会话
session_start();

// 包含数据库连接配置文件
include('c.php');
// 包含页面顶部的 HTML 结构
include('head.php');

// 如果当前 Session 中的 'logged' 状态不为 true (即未登录或登录失败)
if(@$_SESSION['logged']!=true)
{
	// 将 'logged' 状态置空，确保状态一致性
	$_SESSION['logged']='';
	
}

// 检查用户是否已经登录 (要求 'logged' 为 true 并且 'admin' 非空)
if($_SESSION['logged']==true &&  $_SESSION['admin']!='')
{
	// 提示已登录并自动重定向到后台管理面板
	echo "you are logged in :)";
	header('Location: panel.php', true, 302);
}
else
{
// 如果没有登录，输出登录界面的表单
// 这里作者留了一个提示 "Show me your SQLI skills" (展示你的 SQL 注入技巧)，暗示靶机登录处存在注入点
echo '<div align=center style="margin:30px 0px 0px 0px;">
<font size=8 face="comic sans ms">--==[[ billu b0x ]]==--</font> 
<br><br>
Show me your SQLI skills <br>
<form method=post>
Username :- <Input type=text name=un> &nbsp Password:- <input type=password name=ps> <br><br>
<input type=submit name=login value="let\'s login">';
}

// 处理点击登录按钮提交的数据
if(isset($_POST['login']))
{
	// 【安全隐患/漏洞逻辑分析】
	// 获取用户名和密码: 先使用 urldecode 解码，然后使用 str_replace 移除了所有的单引号 (')
	// 开发者试图用这种方式防止用户依靠单引号来闭合 SQL 语句，以此防御最基础的 SQL 注入。
	$uname=str_replace('\'','',urldecode($_POST['un']));
	$pass=str_replace('\'','',urldecode($_POST['ps']));
	
	// 【高危 SQL 注入漏洞：转义符绕过 (Backslash Bypass)】
	// 注意 SQL 语句的拼接顺序是先 pass 后 uname： 
	// $run = "select * from auth where pass='$pass' and uname='$uname'"
	// 
	// 绕过方法：
	// 把 password 的值设置为一个反斜杠: \
	// 把 username 的值设置为 : or 1=1#
	// 
	// 代入拼接后，最终执行的 SQL 语句会变成：
	// select * from auth where pass='\' and uname='or 1=1#'
	// 此时由于反斜杠 \ 转除了其后的单引号，导致 pass 的值变成了字面量常量 `\' and uname=` 。
	// 后面的 `or 1=1#` 将成为一个独立的逻辑条件，由于 1=1 永远为真，而 # 注释掉了后面的单引号，因此成功绕过了认证！
	$run='select * from auth where  pass=\''.$pass.'\' and uname=\''.$uname.'\'';
	
	// 执行查询
	$result = mysqli_query($conn, $run);
	
// 如果查询结果影响的行数大于 0 (即有符合条件的账号，或者逻辑绕过成功使得整个库被查询出来)
if (mysqli_num_rows($result) > 0) {

	// 提取出结果集中的第一条数据记录
	$row = mysqli_fetch_assoc($result);
	   echo "You are allowed<br>";
	   // 设置登录成功的状态
	   $_SESSION['logged']=true;
	   // 将从数据库读取到的 username 记录(如果万能密码绕过，通常是表中的第一位用户) 赋给 'admin' session
	   $_SESSION['admin']=$row['username'];
	   
	 // 登录成功后跳转到后台
	 header('Location: panel.php', true, 302);
   
}
else
{
	// 账号密码错误或者 SQL 注入失败时，在前端弹窗提示
	echo "<script>alert('Try again');</script>";
}
	
}

// 页面底部的装饰性版权信息
echo "<font size=5 face=\"comic sans ms\" style=\"left: 0;bottom: 0; position: absolute;margin: 0px 0px 5px;\">B0X Powered By <font color=#ff9933>Pirates</font> ";

?>


