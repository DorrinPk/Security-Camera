<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	session_start();
	include("includes/config.php");

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//username and password sent from form
		$myusername = addslashes($_POST['username']);
		$mypassword = md5(addslashes($_POST['password']));
				
		$sql = "SELECT userid FROM users WHERE username='$myusername' and password='$mypassword'";
		$result = mysqli_query($bd, $sql);
		$count = mysqli_num_rows($result);

		//if result matched $myusername and $mypassword, table row must be 1 row
		if($count == 1)
		{
			//session_register("myusername");
			$_SESSION['login_admin']=$myusername;
			header("location: https://ec2-54-191-145-180.us-west-2.compute.amazonaws.com/admin/index.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Login</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
  </body>
</html>

