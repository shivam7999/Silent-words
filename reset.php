	<?php  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include_once 'includes/dbh.inc.php';
		if(isset($_SESSION['user_uid']) {
		$opwd=mysqli_real_escape_string($conn,$_POST['oldpass'])
		$pwd =mysqli_real_escape_string($conn,$_POST['newpass']) ;
		$umd=$_SESSION['user_uid'];
		$hashedpwd = password_hash($pwd,PASSWORD_DEFAULT);
		$sql1="SELECT user_pwd FROM data where user_name='$umd';";
		$result= mysqli_query($conn,$sql1);
		$resultcheck=mysqli_num_rows($result);
		if(empty($pwd)){
			header("Location: reset.html?error:emptyfield");
			exit();
		}
		if($resultcheck<1)
		{
			header("Location: reset.html?password=Invalid");
			exit();
		}
		else
			{if($row=mysqli_fetch_assoc($result)){
				$hashedpwdcheck = password_verify($opwd,$row['user_pwd']);
				if($hashedpwdcheck == false){ session_destroy();
      echo "<script>location.href='index.html'</script>";
			exit();}
			else if($hashedpwdcheck == true){
				$sql="UPDATE  data set user_pwd=? where user_name='$umd';";
				$stmt= mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
	header("Location: reset.html?error:sql");
}else{
	mysqli_stmt_bind_param($stmt,"s",$hashedpwd);
	mysqli_stmt_execute($stmt);
}
				echo "<script>location.href='front.html'</script>";	
		}
	}
}
}
	else{
	echo "<script>location.href='change.html?errorjuda'</script>";	
	}
	?>