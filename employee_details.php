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
                            <h4 class="page-header">User Details</h4>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                   
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Details
                                </div>
                                <!-- /.panel-heading -->
                                
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped ">
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $employee_ID = $_GET['view_employee'];
                                                    // $update = "UPDATE leaves SET isRead = 1 WHERE leave_ID = '$leave_ID'";
                                                    $search = "SELECT * from employee JOIN user JOIN department on user.employee_ID=employee.employee_ID AND employee.department_ID = department.department_ID WHERE employee.employee_ID='$employee_ID'";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                                <img class="img-thumbnail img-responsive" width="150px" src="employee_image/<?php echo $row['file']; ?>">
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td><b>Employee Name</b></td>
                                                            <td><a href="edit_employee?edit_employee=<?php echo $row['employee_ID']?>"><?php echo $row['employee_fname']." ". $row['employee_lname']?></a></td>
                                                            <td><b>Emp ID</b></td>
                                                            <td><?php echo $row['employee_ID']?></td>
                                                            <td><b>Gender</b></td>
                                                            <td><?php echo $row['gender']?></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                             <td><b>Date of Birth</b></td>
                                                            <td><?php echo $row['date_of_birth']?></td>
                                                            <td><b>Email ID</b></td>
                                                            <td><?php echo $row['email']?></td>
                                                            <td><b>Contact no</b></td>
                                                            <td><?php echo $row['phone_number']?></td>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td><b>Address</b></td>
                                                             <td><?php echo $row['address']?></td>
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
                                                            <td><?php echo $row['role']?></td>
                                                            <td colspan="5"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Work Place</b></td>
                                                            <td><?php echo $row['work_place']?></td>
                                                            <td><b>Position</b></td>
                                                            <td><?php echo $row['position']?></td>
                                                        </tr>
                                                        
                                                        <?php } ?>
                                                        
                                            </tbody>
                                        </table>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        <?php include('include/footer.php'); ?>
