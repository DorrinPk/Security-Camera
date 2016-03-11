<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	session_start();
	include("../includes/config.php");

	if(!(isset($_SESSION['login_admin'])) && $_SESSION['login_admin'] !='')
	{
		header("location: https://ec2-54-191-145-180.us-west-2.compute.amazonaws.com/index.php");
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
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
    <style type="text/css">
	.table-format{
	margin: 20px;	
	}
    </style>
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
            <li><a href="addadmin.php">Add Admin</a></li>
            <li class="active"><a href="history.php">History</a></li>
	    <li><a href="addface.php">Add Face</a></li>
	    <li><a href="../logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>Security Camera Admin Dashboard</h1>
	<div class="table-format">
        <table class="table table-hover table-bordered">
	  <thead>
	    <tr>
		<th>History ID</th>
		<th>User ID</th>
		<th>Time</th>
	   </tr>
	  </thead>
	<tbody>
<?php
	$sql="SELECT * FROM history";
	$result=mysqli_query($bd,$sql);
	$rows=array();
	while($row=mysqli_fetch_array($result))
	{
		$rows[]=$row;
	}
	if(count($rows)!=0)
	{	
		foreach($rows as $row)
		{
			echo "<tr>";
			echo "<td>" . $row['historyid'] . "</td>";
			echo "<td>" . $row['userid'] . "</td>";
			echo "<td>" . $row['time'] . "</td>";
			echo "</tr>";
		}
	}
?>
	</tbody>
	</div>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
