<?php
include('include/db_connect.php');
session_start();
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
$encryption_iv = '1234567891011121';
$encryption_key = "GeeksforGeeks";
$decryption_iv = '1234567891011121';
$decryption_key = "GeeksforGeeks";
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
                             <h5 class="page-header" style="text-align: center;">ALL REGISTERED EXAMINATIONS</h5>
                        </div>
                        <!-- /.col-lg-12 -->
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
                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     Manage registered primary schools
                                    <a href="add_school" class="btn btn-sm btn-primary pull-right">Add school</a>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Center no.</th>
                                                    <th>School name</th>
                                                    <th>School type</th>
                                                    <th>District</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_school_p";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo $row['school_no']?></td>
                                                            <td><?php echo $row['school_name']?></td>
                                                            <td><?php echo $row['school_type']?></td>
                                                            <td><?php echo $row['school_district']?></td>
                                                            <td><center>
                                                                <a title="Edit School" href="edit_leave?edit_leave=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to edit this School?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete School" href="controller/delete_school?delete=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
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
                    </div> -->

                    <!-- <div class="row">
                        <div class="col-lg-12">
                            <h5 class="page-header">All Registered Schools based on District</h5>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                     <table class="table table-bordered">
                                        <tr>
                                                        <td>CLASS</td>
                                                        <td width="10px">No:</td>
                                        </tr>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT DISTINCT school_district FROM tbl_school_p WHERE class_level='o_level' ORDER BY school_district ASC";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $district=openssl_encrypt ($row['school_district'], $ciphering, $encryption_key, $options, $encryption_iv);
                                                        ?>
                                                            <tr>
                                                                <td><a href="primaryresult?district=<?php echo $district; ?>"><?php echo strtoupper($row['school_district']);?></a></td>
                                                                <td>
                                                                    <a href="primaryresult?district=<?php echo $district; ?>">
                                                                    <?php
                                                                            $school_count = "SELECT * FROM tbl_school_p where school_district='$row[school_district]'";
                                                                            $count_query = mysqli_query($con, $school_count);
                                                                            echo mysqli_num_rows($count_query);
                                                                        ?>
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                    <?php  } ?>
                                       </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                     <!-- Manage registered schools -->
                                     <h5 style="text-align: center;">
                                     <?php
                                                    include('include/config.php');
                                                    $district=@openssl_decrypt ($_GET['district'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    echo strtoupper( $district ). " CLASS";
                                      ?></h5>
                                    <!-- <a href="add_student" class="btn btn-sm btn-primary pull-right">Add student</a> -->
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S/n</th> -->
                                                    <th>Exam No</th>
                                                    <th>Exam  Name</th>
                                                    <th>Exam Type</th>
                                                    <th>Class</th>
                                                    <th>Students </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <?php
                                                    include('include/config.php');
                                                    $district=@openssl_decrypt ($_GET['district'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM tbl_school_p WHERE school_district='$district'";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $encryption_key, $options, $encryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <!-- <td class="center"><?php echo $i ?></td> -->
                                                            <td>
                                                                 <a title="view result" href="view_primaryresult?view=<?php echo $school_no; ?>"> <span class="fa fa-files-o"></span> <?php echo strtoupper($row['school_no'])?> </a>
                                                            </td>
                                                            <td><?php echo strtoupper( $row['school_name'])?></td>
                                                            <td><?php echo strtoupper($row['school_type'])?></td>
                                                            <td><?php echo strtoupper($row['school_district'])?></td>
                                                            <td><center>
                                                                <?php
                                                                    $count = "SELECT * FROM tbl_student WHERE school_no = '$row[school_no]'";
                                                                    $run_count = mysqli_query($con, $count);
                                                                    echo mysqli_num_rows($run_count);
                                                                ?>
                                                           </center> </td>
                                                           <td><center>


                                                           <a title="Enter Marks" href="enter_primaryresult?no=<?php echo $school_no; ?>" class="btn btn-xs btn-warning"> Enter results</a>

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
