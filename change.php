	<?php  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include_once 'includes/dbh.inc.php';
		if(isset($_SESSION['ema'])) {
		$pwd =mysqli_real_escape_string($conn,$_POST['newpass']) ;
		$eml=$_SESSION['ema'];
		$hashedpwd = password_hash($pwd,PASSWORD_DEFAULT);
		$sql="UPDATE  data set user_pwd=? where email='$eml';";
		$stmt= mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
	header("Location: change.html?error:sql");
}else{
	mysqli_stmt_bind_param($stmt,"s",$hashedpwd);
	mysqli_stmt_execute($stmt);
}
		$sql1="SELECT user_pwd FROM data where email='$eml';";
		$result= mysqli_query($conn,$sql1);
		$resultcheck=mysqli_num_rows($result);
		if(empty($pwd)){
			header("Location: change.html?error:emptyfield");
			exit();
		}
		if($resultcheck<1)
		{
			header("Location: mylogin.html?login=Invalid");
			exit();
		}
		else
			{if($row=mysqli_fetch_assoc($result)){
				$hashedpwdcheck = password_verify($pwd,$row['user_pwd']);
				if($hashedpwdcheck == false){
			header("Location: change.html?change=Invalid");
			exit();}
			else if($hashedpwdcheck == true){
				if(isset($_SESSION['ema']))
    {
				session_destroy();
				echo "<script>location.href='index.html'</script>";
				}	
		}
	}
}
}
	else{
	echo "<script>location.href='change.html?errorjuda'</script>";	
	}
	?>