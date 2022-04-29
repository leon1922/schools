<?php
//login.php

include('include/db_connect.php');
session_start();
if(isset($_SESSION['type']))
{
	header("location:index");
}
$message = '';

if(isset($_POST["login"]))
{
	$query = "
	SELECT * FROM employee JOIN user on employee.employee_ID = user.employee_ID
		WHERE email = :email
	";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
				'email'	=>	$_POST["email"]
			)
	);
	$count = $statement->rowCount();
	if($count > 0)
	{
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			if($row['status'] == 'Active')
			{
				if(password_verify($_POST["password"], $row["password"]))
				{
					$_SESSION['type'] = $row['role'];
                    $_SESSION['employee_ID'] = $row['employee_ID'];
                    $_SESSION['file'] = $row['file'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['employee_lname'] = $row['employee_lname'];
                    
					header("location:index");
				}
				else
				{
					$message = "<label class='text-danger'>Sorry, Wrong Password!!<label>";
				}
			}
			else
			{
				$message = "<label class='text-danger'>Sorry, Your account is disabled, Contact System Administrator!!</label>";
			}
		}
	}
	else
	{
		$message = "<label class='text-danger alert-dismissable'>Sorry, Wrong Email Address!!</labe>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="./img/favicon.png" type="image/gif">
        <title>KSSEB Results System</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
    .bg_rgba {
  background-image:url("img/ksseb.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
 
}
        </style>
        
    </head>
    <body class='bg_rgba'>
 

        <div class="container" style="margin-top: 25px;">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                           <center><img src="img/favicon.png" height="150px"></center>
                        </div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                            <?php echo $message; ?>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post" role="form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button class="btn btn-sm btn-success btn-block" type="submit" name="login">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>




  


        

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>

    </body>
</html>
