<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	session_start();
	include("../includes/config.php");
	$usernameexists=true;
	$firsttime=true;
	$useradded=false;

	if(!(isset($_SESSION['login_admin']))&& $_SESSION['login_admin']!='')
	{
		header("location: https://ec2-54-191-145-180.us-west-2.compute.amazonaws.com/index.php");
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$myusername = addslashes($_POST['username']);
		$mypassword= md5(addslashes($_POST['password']));

		$sql = "SELECT userid FROM users WHERE username='$myusername'";
		$result = mysqli_query($bd, $sql);
		$count = mysqli_num_rows($result);
		
		if($count == 0)
		{
			$firsttime=false;
			$usernameexists=false;
			$sql = "INSERT INTO users(username,password) VALUES('$myusername','$mypassword')";
			if(mysqli_query($bd, $sql))
			{
				$useradded=true;
			}
			else
			{
				$useradded=false;
			}
		}
		else
		{
			$usernameexists=true;
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

    <title>Admin Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/starter-template.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Dashboard</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="addadmin.php">Add Admin</a></li>
            <li><a href="history.php">History</a></li>
	    <li><a href="addface.php">Add Face</a></li>
	    <li><a href="../logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>Security Camera Admin Dashboard</h1>
          
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Create New Admin Account</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input name="username" type="text" id="userName" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
<?php
	if($usernameexists && !$firsttime){
	echo "<p>The username that was input already exists.</p>";
	}
	elseif(!$usernameexists && $useradded){
	echo "<p>The user has been added</p>";
	}
	elseif(!$usernameexists && !$useradded){
	echo "<p>Error, user was not added.  Try again.</p>";
	echo "Error: " . $sql . "<br>" . mysqli_error($bd);
	}
?>
      </form>      
      </div>

    </div>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
