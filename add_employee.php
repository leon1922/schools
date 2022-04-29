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
<head>
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
                            <h4 class="page-header">Users</h4>
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
                            if(!empty($_GET['exist'])) {
                                $show = $_GET['exist'];
                                echo "<div class='col-md-12'><div class='alert alert-warning alert-dismissible'>
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
                                    Add new user
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-12">                                            
                                            <form action="controller/add_employee.php" method="post" role="form" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" name="employee_ID" class="form-control" placeholder="Employee ID" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="employee_fname" class="form-control" placeholder="First name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="employee_lname" class="form-control" placeholder="Last name" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                        <input type="date" name="date_of_birth" class="form-control" placeholder="Birthbate" required>
                                                                    </div>
                                                            <div class="row form-group">
                                                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                        <div class="row form-group">
                                                                <input type="file"  name="file" class="form-control">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <select name="gender" class="form-control" required>
                                                                            <option disabled selected value="" required>Gender...</option>
                                                                            <option>Male</option>
                                                                            <option>Female</option>
                                                                            <option>Other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                <select name="marital_status" class="form-control" required>
                                                                            <option disabled selected value="" required>Marital Status...</option>
                                                                            <option>Married</option>
                                                                            <option>Single</option>
                                                                        </select>
                                                            </div>
                                                                </div>
                                                            </div>
                                                             
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <select name="department_ID" class="form-control" required>
                                                                            <option disabled selected value="" required>Department...</option>
                                                                            <?php
                                                                                include ("include/config.php");
                                                                                $query = "SELECT * FROM department";
                                                                                $run_query = mysqli_query($con, $query);
                                                                                while($row = mysqli_fetch_array($run_query)){
                                                                                    echo "<option value='".$row['department_ID']."'>".$row['department_name']."</option>";
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="work_place" class="form-control" placeholder="Work place" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="position" class="form-control" placeholder="position" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="city" class="form-control" placeholder="City/Town" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="country" class="form-control" placeholder="Country" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <select name="role" class="form-control" required>
                                                                            <option disabled selected value="" required>Role...</option>
                                                                            <option>Admin</option>
                                                                            <option>User</option>
                                                                        </select>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="number" name="phone_number" class="form-control" placeholder="Mobile number" required>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>
                                                    </div>
                                                </div>
                                                <button name="submit" name="submit" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
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