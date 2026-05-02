<?php
include '../config.inc'; // 引入数据库配置（地址、用户名、密码等）
include '../opendb.inc'; // 执行数据库连接，建立 $conn 连接

// 从请求中获取用户输入的数据（包含 GET 或 POST）
$username = $_REQUEST["user_name"]; // 获取表单提交的用户名
$password = $_REQUEST["password"];  // 获取表单提交的密码
$surname = $_REQUEST["surname"];
$dosomething = $_REQUEST["do"];     // 获取操作指令（如 logout）

// 只有当用户名和密码都有输入时，才执行登录验证逻辑
if ($username <> "" and $password <> "") {
	/* 
	   【高危：SQL 注入漏洞】
	   1. $username 直接拼接，没有任何转义。
	   2. stripslashes($password) 移除了单引号转义，彻底关掉了最后的安全防线。
	*/
	$query  = "SELECT * FROM accounts WHERE username='". $username ."' AND password='".stripslashes($password)."'";
	
	// 执行查询。如果语法错误（常见于注入测试），die() 会输出 SQL 语句，导致敏感信息泄露。
	$result = mysql_query($query) or die('<b>SQL Error:</b>' . mysql_error($conn) . '<p><b>SQL Statement:</b>' . $query);
	
	// 检查查询结果是否包含匹配的行。如果有，则说明登录成功。
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_array($result, MYSQL_ASSOC); // 提取用户信息
		setcookie("uid", $row['cid']); // 【会话管理点】直接用 Cookie 存储用户 ID，极易被客户端篡改伪造
		$failedloginflag=0;
		echo '<meta http-equiv="refresh" content="0;url=index.php">'; // 登录成功跳转
	} else {
		$failedloginflag=1; // 设置失败标志供 login.php 显示
	}
}

switch ($dosomething) {
	case "logout":
		setcookie('uid','',1);
		break;
}

?>
<html><head>
<?php
if ($dosomething  == "logout") {
	echo '<meta http-equiv="refresh" content="0;url=index.php">';
	$auth = 0;
}
?>
</head>
<body bgcolor="#00bbcc">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr><td bgcolor="#00bbcc"align="center" colspan="2">
		<table width="100%">
		<td valign="top"><br></td>
		<td align="center" valign="top"><h1><b>Nakimura Industries Production Server</b></h1>
		<?php
		/* 
		   【会话验证】
		   每次页面加载都会根据浏览器传来的 uid Cookie 到数据库中查找用户。
		   由于直接信任客户端 Cookie 且无中间层（如 SessionID），攻击者可更改 Cookie 变成任意用户。
		*/
		$query  = "SELECT * FROM accounts WHERE cid='".$_COOKIE["uid"]."'";
		$result = mysql_query($query) or die('Error Connecting to Database');
		echo mysql_error($conn);
		echo mysql_error($conn);
		// 如果结果集不为空，设置全局变量 $auth 为 1，表示已通过认证
		if (mysql_num_rows($result) > 0) {
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$logged_in_user = $row['username']; // 当前用户名
				$upload = $row['upload'];           // 用户的上传权限
				$auth = 1;                          // 已登录标志
				echo "Welcome, " .$logged_in_user. ".";
			}
		} else {
			$logged_in_user = "anonymous";
			$auth = 0;                          // 未登录标志
			echo '<font color="#ff0000">Not logged in</font>';
		}
		?>
		</td>
		</table>
	</td></tr>
	<tr>
		<td bgcolor="#00bbcc" valign="top" width="12%">
		<hr>
		<a href="index.php">Home</a><br>
		<?php
		if ( $auth == 0 ) { echo "<a href='?page=login.php'>Login</a><br />"; }
		if ( $auth == 1 ) {
			echo "<a href='?page=employeedir.php'>Directory</a><br />";
			echo "<a href='?page=messageboard.php'>Message Board</a><br />";
			echo "<a href='?page=calender.php'>Calender</a><br />";
			echo "<a href='?page=upload.php'>Upload</a><br />";
			echo "<a href='?page=ssp.php'>Security</a><br />";
			echo "<a href='?do=logout'>Logout</a><br />";
		}
		?>
		<hr>
		</td>
		<td  valign="top" width="80%">
		<blockquote>

