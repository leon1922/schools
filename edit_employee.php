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
            border-color: red;
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
                                    include ('include/config.php');
                                    $employee_ID = $_GET['edit_employee'];
                                    if(isset($_POST['submit'])){
                                        $employee_fname = mysqli_real_escape_string($con, $_POST['employee_fname']);
                                        $employee_lname = mysqli_real_escape_string($con, $_POST['employee_lname']);
                                        $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
                                        $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
                                        // $email = mysqli_real_escape_string($con, $_POST['email']);
                                        $address = mysqli_real_escape_string($con, $_POST['address']);  
                                        $gender = mysqli_real_escape_string($con, $_POST['gender']);
                                        $city = mysqli_real_escape_string($con, $_POST['city']);
                                        $country = mysqli_real_escape_string($con, $_POST['country']);
                                        $marital_status = mysqli_real_escape_string($con, $_POST['marital_status']);
                                        $department_ID = mysqli_real_escape_string($con, $_POST['department_ID']);
                                        $work_place = mysqli_real_escape_string($con, $_POST['work_place']);
                                        $position = mysqli_real_escape_string($con, $_POST['position']);
                                        $status = mysqli_real_escape_string($con, $_POST['status']);
                                        
                                    $update = "UPDATE employee SET employee_fname= '$employee_fname', employee_lname = '$employee_lname', date_of_birth = '$date_of_birth', phone_number= '$phone_number',  address = '$address', gender = '$gender', city= '$city', country = '$country', marital_status = '$marital_status', department_ID = '$department_ID' WHERE employee_ID='$employee_ID'";
                                    $update_query = mysqli_query($con, $update);
                                    if($update_query){
                                        $update2 = "UPDATE user SET work_place= '$work_place', position = '$position', status = '$status' WHERE employee_ID='$employee_ID'";
                                        $update_query2 = mysqli_query($con, $update2);
                                        if($update_query2){
                                            echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            Updated Successful
                                            </div></div>";
                                        }else{
                                            echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        Failed!, Please try again.
                                        </div></div>";
                                        }
                                        
                                    }else{
                                        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        Failed!, Please try again.
                                        </div></div>";
                                    }
                                }
                                    ?>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Edit User Details
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-12">
                                        <?php
                                          include('include/config.php');
                                          $employee_ID = $_GET['edit_employee'];
                                          $search = "SELECT * from employee JOIN user JOIN department on user.employee_ID=employee.employee_ID AND employee.department_ID = department.department_ID WHERE employee.employee_ID='$employee_ID'";
                                          $run_query = mysqli_query($con, $search);
                                          while($row = mysqli_fetch_array($run_query)){
                                          ?>                                           
                                            <form action="" method="post" role="form">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" name="employee_ID" value="<?php echo $row['employee_ID'] ?>" class="form-control" placeholder="Employee ID" required disabled>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="employee_fname" value="<?php echo $row['employee_fname'] ?>" class="form-control" placeholder="First name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="employee_lname" value="<?php echo $row['employee_lname'] ?>" class="form-control" placeholder="Last name" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                        <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth'] ?>" class="form-control" placeholder="Birthbate" required>
                                                                    </div>
                                                            <div class="row form-group">
                                                                <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Email" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <select name="gender" class="form-control">
                                                                            <option selected value="<?php echo $row['gender'] ?>" required><?php echo $row['gender'] ?></option>
                                                                            <option>Male</option>
                                                                            <option>Female</option>
                                                                            <option>Other</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <select name="marital_status" class="form-control">
                                                                            <option selected value="<?php echo $row['marital_status'] ?>" required><?php echo $row['marital_status'] ?></option>
                                                                            <option>Single</option>
                                                                            <option>Married</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             
                                                            
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="work_place" value="<?php echo $row['work_place'] ?>" class="form-control" placeholder="Work place" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="position" value="<?php echo $row['position'] ?>" class="form-control" placeholder="position" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="city" value="<?php echo $row['city'] ?>" class="form-control" placeholder="City/Town" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="country" value="<?php echo $row['country'] ?>" class="form-control" placeholder="Country" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="text" name="phone_number" value="<?php echo $row['phone_number'] ?>" class="form-control" placeholder="Mobile number" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                        <select name="status" class="form-control input">
                                                                            <option selected value="<?php echo $row['status'] ?>" required><?php echo $row['status'] ?></option>
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                    </div>

                                                           <div class="row">
                                                            <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <input type="text" name="address" value="<?php echo $row['address'] ?>" class="form-control" placeholder="Address" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row form-group">
                                                                        <select name="department_ID" class="form-control">
                                                                            <option selected value="<?php echo $row['department_ID'] ?>" required><?php echo $row['department_name'] ?></option>
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
                                                                
                                                            </div> 
                                                        </div>
                                                        <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>
                                                    </div>
                                                </div>
                                                <button name="submit" name="submit" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                                            </form>
                                           <?php } ?>
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