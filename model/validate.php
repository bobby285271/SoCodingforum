<?php
include  '../core/mysqlDB.php';

// 接收登录信息
$user_name = $_POST['user_name'];
$user_password = $_POST['user_password'];

// 查找当前提交的用户名
$sql = "SELECT * FROM user WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// 提取该用户的真实密码
$real_password = $row['user_password'];
mysqli_close($conn);

// 检查用户密码是否填写完整
if ( empty($user_name) ) {
	jump('./login.php', '用户名不能为空');
}
else if ( empty($user_password) ) {
	jump('./login.php', '密码不能为空');
}
else if ( mysqli_num_rows($result) == 0 ) {
	jump('./login.php', '用户名不存在');
}
// 比对密码的 MD5 是否一致
else if ( md5($user_password) === $real_password ) {
	// TODO：保存登录状态
	jump('../index.php', '登录成功');
}
else{
	jump('./login.php', '密码失败');
}

