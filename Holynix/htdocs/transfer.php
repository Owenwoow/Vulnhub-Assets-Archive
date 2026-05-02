<?php
// 检查用户是否已登录（$auth 变量在 header.php 中定义）
if ( $auth == 0 ) {
    echo "<center><h2>Content Restricted</h2></center>"; // 未登录用户看到受限提示
} else {
    // 检查当前登录用户是否有上传权限（从数据库 accounts 表的 upload 字段读取）
	if ( $upload == 1 )
	{
		$homedir = "/home/".$logged_in_user. "/"; // 定义目标用户的主目录路径
		$uploaddir = "upload/";                   // 定义临时上传目录
		// 构造临时目标路径。basename() 用于提取文件名，防止目录遍历攻击。
		$target = $uploaddir . basename( $_FILES['uploaded']['name']) ;
		$uploaded_type = $_FILES['uploaded']['type']; // 获取上传文件的 MIME 类型
		$command=0;
		$ok=1;

		// 如果上传的是 Gzip 压缩包且勾选了“自动解压”选项，设置 $command 标志为 1
		if ( $uploaded_type =="application/gzip" && $_POST['autoextract'] == 'true' ) {	$command = 1; }

		if ($ok==0)
		{
			echo "Sorry your file was not uploaded";
			echo "<a href='?index.php?page=upload.php' >Back to upload page</a>";
		} else {
			// 将上传的临时文件移动到指定的临时目录 ($target)
        		if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target))
			{
				echo "<h3>The file '" .$_FILES['uploaded']['name']. "' has been uploaded.</h3><br />";
				echo "The ownership of the uploaded file(s) have been changed accordingly.";
				echo "<br /><a href='?page=upload.php' >Back to upload page</a>";
				
				// --- 核心执行逻辑（包含重大安全风险） ---
				if ( $command == 1 )
				{
					/* 
					   【命令注入漏洞】
					   使用 sudo tar 解压。如果文件名包含特殊字符（如 ; 或 `），
					   可能导致以 root 权限执行任意命令。
					*/
					exec("sudo tar xzf " .$target. " -C " .$homedir);
					exec("rm " .$target); // 删除临时文件
				} else {
					/* 
					   【命令注入漏洞】
					   直接将变量拼接进系统命令。如果文件名被恶意构造，
					   可能会执行额外的 Linux 命令。
					*/
					exec("sudo mv " .$target. " " .$homedir . $_FILES['uploaded']['name']);
				}
				// 运行一个本地脚本来更新文件所有权
				exec("/var/apache2/htdocs/update_own");
        		} else {
				echo "Sorry, there was a problem uploading your file.<br />";
				echo "<br /><a href='?page=upload.php' >Back to upload page</a>";
			}
		}
	} else { 
		// 无上传权限的错误提示
		echo "<br /><br /><h3>Home directory uploading disabled for user " .$logged_in_user. "</h3>"; 
	}
}
?>
