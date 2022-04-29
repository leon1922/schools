<?php
session_start();
if(!isset($_SESSION["type"]))
{
	header("location:login");
} 
if (empty($_SESSION['token'])) { 
    $length = 32;
    $_SESSION['token'] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length); 
}
include('include/header.php'); 
?>
    <style>
        .input{
            border-top: none;
        }
    </style>
</head>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="page-header">Password</h4>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                            if(!empty($_GET['success'])) {
                            $show = $_GET['success'];
                                echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        $show
                                    </div></div>";
                              }

                              if(!empty($_GET['fail'])) {
                                $show = $_GET['fail'];
                                    echo "<div class='col-md-12'><div class='alert alert-danger alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            $show
                                        </div></div>";
                                  }
                        ?>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Change Password
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-12">                                            
                                            <form action="controller/change_password.php" method="post" role="form">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="password" name="old_password" class="form-control" placeholder="Current Password" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>
                                                    </div>
                                                </div>
                                                <button name="submit" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                                            </form>
                                        </div>
                                        <!-- /.col-lg-6 (nested) -->
                                    </div>
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
            <script>
                var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
                function validatePassword(){
                    if(password.value != confirm_password.value) {
                        confirm_password.setCustomValidity("Passwords Don't Match");
                        } else {
                            confirm_password.setCustomValidity('');
                        }
                }
                
                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;
                
            </script>

        <?php include('include/footer.php') ?>