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
                            <h4 class="page-header">Users</h4>
                        </div>
                        <!-- /.col-lg-11 -->
                        <?php
                                    if(!empty($_GET['del'])) {
                                        $show = $_GET['del'];
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
                                    Manage Primary Users
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <td>Photo</td>
                                                    <th>Name</th>
                                                    <th>DOB</th>
                                                    <th>Email</th>
                                                    <!-- <th>Address</th>
                                                    <th>Phone</th> -->
                                                    <th>Gender</th>


                                                    <!-- <th>Location</th>
                                                    <th>Marital status</th> -->
                                                    <th>Department</th>
                                                    <!-- <th>Work Place</th>
                                                    <th>Position</th> -->
                                                    <th>Action</th>
                                                </tr>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * from employee JOIN user JOIN department on user.employee_ID=employee.employee_ID AND employee.department_ID = department.department_ID WHERE user.category='primary'";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td width="10"><?php echo $i ?></td>

                                                            <td>
                                                            <?php if($row['file'] == ""){
                                                                echo "no image";
                                                            }else{

                                                            }
                                                            ?>
                                                            <img class="img-responsive" height=100 width=100 src="employee_image/<?php echo $row['file']; ?>"></td>

                                                            <td><?php echo $row['employee_fname']." ". $row['employee_lname']?></td>
                                                            <td><?php echo $row['date_of_birth']?></td>
                                                            <td><?php echo $row['email']?></td>
                                                            <!-- <td><?php echo $row['address']?></td>
                                                            <td><?php echo $row['phone_number']?></td> -->
                                                            <td><?php echo $row['gender']?></td>
                                                            <!-- <td><?php echo $row['city']. ", " .$row['country']?></td>
                                                            <td><?php echo $row['marital_status']?></td> -->
                                                            <!-- <td><?php echo $row['work_place']?></td>
                                                            <td><?php echo $row['position']?></td> -->
                                                            <td><?php echo $row['department_name']?></td>
                                                            <td>
                                                            <center>
                                                            <a title="See More Employee Details" href="employee_details?view_employee=<?php echo $row['employee_ID']?>" class=""><i class="fa fa-eye" style="color:blue;"></i></a>
                                                                <a title="Edit Employee Details" href="edit_employee?edit_employee=<?php echo $row['employee_ID']?>" onclick="return confirm('Are you sure! you are going to edit this Employee Details?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete Employee Details" href="controller/delete_employee?delete=<?php echo $row['employee_ID']?>" onclick="return confirm('Are you sure! you are going to delete this Employee Details?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
                                                                </center>
                                                            </td>
                                                        </tr>

                                                    <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php include('include/footer.php'); ?>
