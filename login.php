	<?php  if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include_once 'includes/dbh.inc.php';
		if(isset($_POST['login'])) {
		$pwd =mysqli_real_escape_string($conn,$_POST['pwd']) ;
		$username=mysqli_real_escape_string($conn,$_POST['umd']) ;
		$sql="SELECT user_pwd FROM data where user_name='$username';";
		$result= mysqli_query($conn,$sql);
		$resultcheck=mysqli_num_rows($result);
		if(empty($pwd)||empty($username)){
			header("Location: mylogin.html?error:emptyfield");
			exit();
		}
		if($resultcheck<1)
		{
			header("Location: mylogin.html?login=Invalid");
			exit();
		}else{
			if($row=mysqli_fetch_assoc($result)){
				$hashedpwdcheck = password_verify($pwd,$row['user_pwd']);
				if($hashedpwdcheck == false){
					header("Location: mylogin.html?error:wrongpassword");
					exit();
				}else if($hashedpwdcheck == true){
					$_SESSION['user_uid']=$_POST['umd'];
					echo "<script>location.href='front.html'</script>";
				}
			}
		}
	}
	else{
	echo "<script>location.href='mylogin.html?errorjuda'</script>";	
	}
	?>