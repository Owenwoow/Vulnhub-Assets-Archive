<?php
// 启动 Session 会话，用于跟踪管理员/用户的登录状态
session_start();

// 包含数据库连接等配置文件
include('c.php');
// 包含页面头部元素，通常是 HTML 的 <head> 部分和 CSS 样式
include('head2.php');

// 检查 Session 中 'logged' 标志是否为 true
// 如果用户未登录或 'logged' 不存在，则重定向回首页 (index.php) 并终止当前脚本往下执行
if(@$_SESSION['logged']!=true )
{
		header('Location: index.php', true, 302);
		exit();
	
}



echo "Welcome to billu b0x ";

// 渲染一个带有 Logout (退出登录) 按钮的表单
echo '<form method=post style="margin: 10px 0px 10px 95%;"><input type=submit name=lg value=Logout></form>';

// 处理退出登录的逻辑
if(isset($_POST['lg']))
{
	// 清除登录相关的 Session 变量
	unset($_SESSION['logged']);
	unset($_SESSION['admin']);
	// 重定向回首页
	header('Location: index.php', true, 302);
}
echo '<hr><br>';

// 渲染一个下拉选择框表单，用于选择要执行的操作或要加载的页面
echo '<form method=post>

<select name=load>
    <option value="show">Show Users</option>
	<option value="add">Add User</option>
</select> 

 &nbsp<input type=submit name=continue value="continue"></form><br><br>';

// 处理下拉框表单提交后的逻辑
if(isset($_POST['continue']))
{
	// 获取当前工作目录路径
	$dir=getcwd();
	// 获取用户提交的 'load' 参数，并过滤掉其中的 './' 字符
	// 这是一个很弱的安全过滤，企图防止目录遍历 (Directory Traversal)
	$choice=str_replace('./','',$_POST['load']);
	
	// 如果用户选择 'add'，则拼凑路径将 add.php 文件包含进来，并停止后续执行
	if($choice==='add')
	{
       		include($dir.'/'.$choice.'.php');
			die();
	}
	
	// 如果用户选择 'show'，则拼凑路径将 show.php 文件包含进来，并停止后续执行
        if($choice==='show')
	{
        
		include($dir.'/'.$choice.'.php');
		die();
	}
	else
	{
		// 【高危漏洞：本地文件包含 (LFI)】
		// 如果恶意用户抓包截断并修改 POST 数据中的 'load' 参数
		// 不是 'show' 也不是 'add' 的情况下，代码就会直接拼接路径并包含该文件
		// 结合后面的图片上传功能，攻击者可以上传一个包含 PHP 恶意代码的图片(比如 shell.jpg)
		// 然后提交 load=uploaded_images/shell.jpg 即可实现代码执行
		include($dir.'/'.$_POST['load']);
	}
	
}


// 处理文件上传和添加到数据库的逻辑 (通常是在 add.php 内部包含的表单提交上来的 'upload')
if(isset($_POST['upload']))
{
	
	// 获取表单提交的 name, address, id 等信息
	// 使用 mysqli_real_escape_string 转义特殊字符，防止基础的 SQL 注入攻击
	$name=mysqli_real_escape_string($conn,$_POST['name']);
	$address=mysqli_real_escape_string($conn,$_POST['address']);
	$id=mysqli_real_escape_string($conn,$_POST['id']);
	
	// 检查是否上传了图片文件
	if(!empty($_FILES['image']['name']))
	{
		// 对上传的原始文件名进行转义防注入
		$iname=mysqli_real_escape_string($conn,$_FILES['image']['name']);
	// 获取上传文件的后缀名
	$r=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
	// 定义一个只允许白名单后缀的数组
	$image=array('jpeg','jpg','gif','png');
	
	// 检查上传文件的后缀是否在白名单之内
	if(in_array($r,$image))
	{
		// 使用 finfo 来检测文件的真实 MIME 类型特征，防止伪造后缀 (比如把 php 改为 jpg)
		$finfo = @new finfo(FILEINFO_MIME); 
	$filetype = @$finfo->file($_FILES['image']['tmp_name']);
		// 通过正则表达式验证 MIME 类型是否确实是图片格式之一
		if(preg_match('/image\/jpeg/',$filetype )  || preg_match('/image\/png/',$filetype ) || preg_match('/image\/gif/',$filetype ))
				{
					// 如果验证通过，则将临时文件移动到 'uploaded_images/' 目录下
					// 移动时使用的是用户上传的原始文件名 ($_FILES['image']['name'])
					if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploaded_images/'.$_FILES['image']['name']))
							 {
							  echo "Uploaded successfully ";
							  // 构建 SQL 语句，将新用户信息和图片文件名插入 users 数据库表
							  $update='insert into users(name,address,image,id) values(\''.$name.'\',\''.$address.'\',\''.$iname.'\', \''.$id.'\')'; 
							 mysqli_query($conn, $update);
							  
							}
				}
			else
			{
				echo "<br>i told you dear, only png,jpg and gif file are allowed";
			}
	}
	else
	{
		echo "<br>only png,jpg and gif file are allowed";
		
	}
}


}

?>
