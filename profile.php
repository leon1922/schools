<?php
include('include/db_connect.php');
session_start();
if(!isset($_SESSION["type"]))
{
	header("location:login");
} 
include('include/header.php'); 
?>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="page-header">My Profile</h4>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    include ('include/config.php');
                                    if(isset($_POST['submit'])){
                                    $employee_ID = $_SESSION['employee_ID'];
                                    $employee_fname= mysqli_real_escape_string($con, $_POST['employee_fname']);
                                    $employee_lname= mysqli_real_escape_string($con, $_POST['employee_lname']);
                                    $gender = mysqli_real_escape_string($con, $_POST['gender']);
                                    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
                                    $address = mysqli_real_escape_string($con, $_POST['address']);
                                    $update = "UPDATE employee SET employee_fname = '$employee_fname', employee_lname = '$employee_lname', 
                                    gender= '$gender', phone_number = '$phone_number', address = '$address' WHERE employee_ID='$employee_ID'";
                                    $update_query = mysqli_query($con, $update);
                                    if($update_query){
                                        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        Details Updated Successful
                                        </div></div>";
                                    }else{
                                        echo "<div class='col-md-12'><div class='alert alert-warning alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        Failed!, Please try again.
                                        </div></div>";
                                    }
                                }
                                    ?>

<?php
                            if(!empty($_GET['error'])) {
                                $show = $_GET['error'];
                                echo "<div class='col-md-12'><div class='alert alert-warning alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        $show
                                    </div></div>";
                            }
                                    ?>

<?php
                            if(!empty($_GET['empty'])) {
                                $show = $_GET['empty'];
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
                                    My Profile Details
                                </div>
                                <!-- /.panel-heading -->
                               
                                
                                <div class="panel-body">

                                <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $employee_ID = $_SESSION['employee_ID'];
                                                    // $update = "UPDATE leaves SET isRead = 1 WHERE leave_ID = '$leave_ID'";
                                                    $search = "SELECT * from employee JOIN user JOIN department on user.employee_ID=employee.employee_ID AND employee.department_ID = department.department_ID WHERE employee.employee_ID='$employee_ID' LIMIT 1";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                            <img class="img-thumbnail img-responsive" width="150px" src="employee_image/<?php echo $row['file']; ?>">
                                                                <a href="" type="button" data-toggle="modal" data-target="#myModal<?php echo $row['employee_ID']?>"><span class="fa fa-pencil"></span> Change Photo</a>
                                                                <?php include('edit_profile_picture.php') ?>
                                                                </td>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                            </tbody>
                                        </table>
                                         </div>
                                    <div class="table-responsive">
                                        <form action="" method="post" enctype="multipart/form-data">
                                        <table class="table table-striped ">
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $employee_ID = $_SESSION['employee_ID'];
                                                    // $update = "UPDATE leaves SET isRead = 1 WHERE leave_ID = '$leave_ID'";
                                                    $search = "SELECT * from employee JOIN user JOIN department on user.employee_ID=employee.employee_ID AND employee.department_ID = department.department_ID WHERE employee.employee_ID='$employee_ID'";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        ?>
                                                        <tr>
                                                            <td><b>Employee Name</b></td>
                                                            <td>
                                                                <input type="text" name="employee_fname" value="<?php echo $row['employee_fname']?>" class="form-control">
                                                                <input type="text" name="employee_lname" value="<?php echo $row['employee_lname']?>" class="form-control">
                                                            </td>
                                                            <td><b>Emp ID</b></td>
                                                            <td><?php echo $row['employee_ID']?></td>
                                                            <td><b>Gender</b></td>
                                                            <td>
                                                                <select name="gender" class="form-control" required>
                                                                    <option value="<?php echo $row['gender']?>"><?php echo $row['gender']?></option>
                                                                    <option>Male</option>
                                                                    <option>Female</option>
                                                                    <option>Other</option>
                                                                </select>
                                                            
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr>
                                                             <td><b>Date of Birth</b></td>
                                                            <td><?php echo $row['date_of_birth']?></td>
                                                            <td><b>Email ID</b></td>
                                                            <td><?php echo $row['email']?></td>
                                                            <td><b>Contact no</b></td>
                                                            <td><input type="number" name="phone_number" value="<?php echo $row['phone_number']?>" class="form-control"></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td><b>Address</b></td>
                                                             <td><input type="text" name="address" value="<?php echo $row['address']?>" class="form-control"></td>
                                                            <td><b>City</b></td>
                                                            <td><?php echo $row['city']?></td>
                                                            <td><b>Country</b></td>
                                                            <td><?php echo $row['country']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Employee Status</td>
                                                            <td colspan="5">
                                                            <?php
                                                                    if($row['status'] == "Active"){
                                                                        echo "<span style='color: green'><b>Active User</b></span>";
                                                                    }elseif ($row['status'] == "Inactive") {
                                                                        echo "<span style='color: red'><b>Inactive User</b></span>";
                                                                    }elseif ($row['status'] == "Suspended") {
                                                                        echo "<span style='color: blue'><b>Suspended User</b></span>";
                                                                    }
                                                                 ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Role</b></td>
                                                            <td colspan="5"><?php echo $row['role']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Work Place</b></td>
                                                            <td colspan="5"><?php echo $row['work_place']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Position</b></td>
                                                            <td colspan="5"><?php echo $row['position']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6">
                                                                <input type="submit" name="submit" href="" type="button" class="btn btn-sm btn-primary" value="Update Details">
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        
                                            </tbody>
                                        </table>
                                        </form> 
                                         </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        <?php include('include/footer.php'); ?>
