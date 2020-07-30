	<?php  if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	include_once 'includes/dbh.inc.php';
		if(isset($_POST['done'])) {
		$eml =mysqli_real_escape_string($conn,$_POST['vfrmail']) ;
		$sql="SELECT email FROM data where email='$eml';";
		$result= mysqli_query($conn,$sql);
		$resultcheck=mysqli_num_rows($result);
		if(empty($eml)){
			header("Location: mylogin.html?error:emptyfield");
			exit();
		}
		if($resultcheck<1)
		{
			header("Location: mylogin.html?login=Invalid");
			exit();
		}else{
			if($row=mysqli_fetch_assoc($result)){
				if(strcmp($eml,$row['email'])!=0)
				{
					header("Location: mylogin.html?error:emailnotfound");
					exit();
				}else if(strcmp($eml,$row['email']) == 0){
					$_SESSION['ema']=$_POST['vfrmail'];
					echo "<script>location.href='change.html'</script>";
				}
			}
		}
	}
	else{
	echo "<script>location.href='mylogin.html?errorjuda'</script>";	
	}
	?>