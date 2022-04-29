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
                            <h5 class="page-header" style="text-align: center;">ALL STUDENTS REGISTERED FOR EXAMINATION</h5>
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


                    <div class="row">
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                     <table class="table table-bordered">
                                        <tr>
                                                        <td style="text-align: center;">SELECT CLASS</td>
                                                        <td>EXAMS:</td>
                                        </tr>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT DISTINCT school_district FROM registered WHERE school_type='REGISTERED'";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $district=openssl_encrypt ($row['school_district'], $ciphering, $encryption_key, $options, $encryption_iv);
                                                        ?>
                                                            <tr>
                                                                <td><a href="student_primary?district=<?php echo $district; ?>"><?php echo strtoupper ($row['school_district']);?></a></td>
                                                                <td>
                                                                    <a href="student_primary?district=<?php echo $district; ?>">
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
                                     <?php
                                                    include('include/config.php');
                                                    $district=@openssl_decrypt ($_GET['district'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    echo strtoupper($district . " students");
                                      ?>
                                    <!-- <a href="add_student" class="btn btn-sm btn-primary pull-right">Add student</a> -->
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Exam no</th>
                                                    <th>Exam Name</th>
                                                    <th>Type</th>
                                                    <th>Class</th>
                                                    <th>Students</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $district=@openssl_decrypt ($_GET['district'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM tbl_school_p WHERE school_district='$district' ORDER BY school_name ASC";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $encryption_key, $options, $encryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX" style="font-size: 13px;">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo strtoupper( $row['school_no'])?></td>
                                                            <td><?php echo strtoupper( $row['school_name'])?></td>
                                                            <td><?php echo strtoupper( $row['school_type'])?></td>
                                                            <td><?php echo strtoupper( $row['school_district'])?></td>
                                                            <td style="text-align: center;">
                                                                <?php
                                                                    $count = "SELECT * FROM tbl_student WHERE school_no = '$row[school_no]'";
                                                                    $run_count = mysqli_query($con, $count);
                                                                    echo mysqli_num_rows($run_count);
                                                                ?>
                                                                
                                                            </td>
                                                            <td><center>
                                                               <a title="Add students" href="add_student?add=<?php echo $school_no; ?>" class=""><i class="fa fa-plus" style="color:green;"> </i> Add</a>

                                                                <a title="Asign subject to students" href="assign_primarysubject?no=<?php echo $school_no; ?>" class="btn btn-xs btn-warning">subject</a>
                                                                <!-- <a title="Delete School" href="controller/delete_school?delete=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a> -->
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
