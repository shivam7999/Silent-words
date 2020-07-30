<?php
include_once 'includes/dbh.inc.php';
$uid = mysqli_real_escape_string($conn,$_POST['uid']);
$pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
$pwd1 = mysqli_real_escape_string($conn,$_POST['pwd1']);
$username=mysqli_real_escape_string($conn,$_POST['username']) ;
$email=mysqli_real_escape_string($conn,$_POST['Emd']) ;
$yesno=mysqli_real_escape_string($conn,$_POST['yesorno']) ;

		if(empty($uid)||empty($pwd)||empty($email)||empty($username)){
			header("Location: localhost/Silent words/index.htm?login=error");
			exit();
		}
		if(strcmp($pwd,$pwd1)==0)
		{
$hashedpwd = password_hash($pwd,PASSWORD_DEFAULT);
$sql="INSERT INTO data(user,user_pwd,user_name,email,yesno) 
values(?,?,?,?,?);";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	echo "SQL error";
}else{
	mysqli_stmt_bind_param($stmt,"sssss",$uid,$hashedpwd,$username,$email,$yesno);
	mysqli_stmt_execute($stmt);
	echo "<script>location.href='index.html'</script>";
}
}


