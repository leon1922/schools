
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/main.css">
<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<style>
    .my-custom-scrollbar {
position: relative;
height: 300px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
</style>

</head>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->



		<div id="loader-wrapper">
			<div id="loader"></div>

			<div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

		</div>
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
                            <h5 class="page-header" >Today:
                            <?php
                             echo "" . date("l");
                             echo ", " . date("Y-m-d") . "";

                               ?><br>
                            </h5>
 

  <div class="tab-content">
    <!--Primary starts-->
    <div id="primary" class="tab-pane fade in active">
                  <div class="row">
                                             
                                         <div class="col-lg-12">
                                         <?php
                                                 if($_SESSION['type'] == "Admin"){
                                                     ?>
                                             <div class="panel panel-default">
                                                 <div class="panel-heading">
                                                      Dashboard


                                                 </div>
                                                 <!-- /.panel-heading -->

                                                 <div class="panel-body">

                                                 <div class="row">
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-primary">
                                                 <div class="panel-heading">
                                                    Users <i class="fa fa-users"></i>
                                                 </div>
                                                 <a href="manage_employee">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View All
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM user ";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Users
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-green">
                                                 <div class="panel-heading">
                                                   Examination Registered <i class="fa fa-university"></i>

                                                 </div>
                                                 <a href="school_primary">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View all
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_school_p";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Exams
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-red">
                                                 <div class="panel-heading">
                                                     Students <i class="fa fa-graduation-cap"></i>
                                                 </div>
                                                 <a href="registered">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Student Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT   * FROM tbl_student_registered";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-yellow">
                                                 <div class="panel-heading">
                                                     Subjects <span class="fa fa-book"></span>
                                                 </div>
                                                 <a href="primarysubject">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Subjects Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_primary_subject";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                       </div>
                                     <!-- /.row -->

                                         </div>
                                         <hr>
                        <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Students Registered Each Class
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class=" table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Class</th>
                                                    <th>Registered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT DISTINCT school_district FROM registered";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $subject_code=openssl_encrypt ($row['school_district'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo $row['school_district']?></td>
                                                            <td><?php
                                                                    $count = "SELECT * FROM tbl_student_registered WHERE school_district = '$row[school_district]'";
                                                                    $run_count = mysqli_query($con, $count);
                                                                    echo mysqli_num_rows($run_count);
                                                                ?></td>
                                                        </tr>

                                                    <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-share fa-fw"></i> Quick Links
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="add_employee" class="list-group-item">
                                            <i class="fa fa-user fa-fw"></i> Add user
                                        </a>
                                        <!--<a href="school" class="list-group-item">
                                            <i class="fa fa-bell fa-fw"></i> View entered schools
                                        </a>-->
                                        <a href="registered" class="list-group-item">
                                            <i class="fa fa-bar-chart-o fa-fw"></i> Manage students
                                        </a>
                                        <a href="primarysubject" class="list-group-item">
                                            <i class="fa fa-random fa-fw"></i> Manage subject
                                        </a>
                                        <a href="primaryresult" class="list-group-item">
                                            <i class="fa fa-clipboard fa-fw"></i> Enter results(O-Level)
                                        </a>
                                        <a href="alevelresult" class="list-group-item">
                                            <i class="fa fa-clipboard fa-fw"></i> Enter results(A-Level)
                                        </a>

                                    </div>
                                    <!-- /.list-group -->
                                </div>
                                <!-- /.panel-body -->
                    </div>
                        </div>
                <!-- /.container-fluid -->
            </div>
              <?php } ?>
            </div>

    </div>
  </div>
  </div>
  <!--Primary ends-->
  <!--Secondary (O-level) starts-->
    <div id="menu1" class="tab-pane fade">
          <div id="menu1" class="tab-pane fade in active">
                  <div class="row">
                 
      <div class="col-lg-12">
                    <?php
                            if($_SESSION['type'] == "Admin"){
                                                     ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Secondary (O-level) Schools Dashboard


                            </div>
                                                 <!-- /.panel-heading -->

                                                 <div class="panel-body">

                                                 <div class="row">
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-primary">
                                                 <div class="panel-heading">
                                                    Users <i class="fa fa-users"></i>
                                                 </div>
                                                 <a href="manage_employee">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View All
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM employee";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Users
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-green">
                                                 <div class="panel-heading">
                                                   Schools Registered

                                                 </div>
                                                 <a href="school">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View all
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_school_p";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Schools
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-red">
                                                 <div class="panel-heading">
                                                     Departments <span class="fa fa-bar-chart-o"></span>
                                                 </div>
                                                 <a href="student">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Student Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_student_registered";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-yellow">
                                                 <div class="panel-heading">
                                                     Subjects <span class="fa fa-bar-chart-o"></span>
                                                 </div>
                                                 <a href="subject">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Subjects Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_primary_subject";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                       </div>
                                     <!-- /.row -->

                                         </div>
                                         <hr>
                        <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Manage subjects
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Subject code</th>
                                                    <th>Subject name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_primary_subject";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $subject_code=openssl_encrypt ($row['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo $row['subject_code']?></td>
                                                            <td><?php echo $row['subject_name']?></td>
                                                            <td><center>
                                                                <a title="Edit School" href="edit_leave?edit_leave=<?php echo $subject_code; ?>" onclick="return confirm('Are you sure! you are going to edit this School?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete School" href="controller/delete_school?delete=<?php echo $subject_code; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
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

                        <div class="col-lg-4 col-md-6">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-share fa-fw"></i> Quick Links
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="add_employee" class="list-group-item">
                                            <i class="fa fa-user fa-fw"></i> Add user
                                        </a>
                                        <a href="school" class="list-group-item">
                                            <i class="fa fa-bell fa-fw"></i> View entered schools
                                        </a>
                                        <a href="student" class="list-group-item">
                                            <i class="fa fa-bar-chart-o fa-fw"></i> Manage students
                                        </a>
                                        <a href="subject" class="list-group-item">
                                            <i class="fa fa-random fa-fw"></i> Manage subject
                                        </a>
                                        <a href="result" class="list-group-item">
                                            <i class="fa fa-clipboard fa-fw"></i> Enter results
                                        </a>

                                    </div>
                                    <!-- /.list-group -->
                                </div>
                                <!-- /.panel-body -->
                    </div>
                        </div>
                <!-- /.container-fluid -->
            </div>
              <?php } ?>
            </div>

    </div>
  </div>
  </div>
    </div>
    <!--Secondary (O-level) ends-->
    <!--Secondary (A-level) starts-->
    <div id="menu2" class="tab-pane fade">
        <div id="menu2" class="tab-pane fade in active">
                  <div class="row">
                 
      <div class="col-lg-12">
                    <?php
                            if($_SESSION['type'] == "Admin"){
                                                     ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Secondary (A-level) Schools Dashboard


                            </div>
                                                 <!-- /.panel-heading -->

                                                 <div class="panel-body">

                                                 <div class="row">
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-primary">
                                                 <div class="panel-heading">
                                                    Users <i class="fa fa-users"></i>
                                                 </div>
                                                 <a href="manage_employee">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View All
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM employee";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Users
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-green">
                                                 <div class="panel-heading">
                                                   Schools Registered

                                                 </div>
                                                 <a href="school">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">View all
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_school_p";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                                  Schools
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-red">
                                                 <div class="panel-heading">
                                                     Departments <span class="fa fa-bar-chart-o"></span>
                                                 </div>
                                                 <a href="student">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Student Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_student_registered";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>

                                         <div class="col-lg-3 col-md-6">
                                             <div class="panel-yellow">
                                                 <div class="panel-heading">
                                                     Subjects <span class="fa fa-bar-chart-o"></span>
                                                 </div>
                                                 <a href="subject">
                                                     <div class="panel-footer">
                                                         <span class="pull-left">Subjects Registered
                                                         <?php
                                                                     include 'include/config.php';
                                                                     $query1 = "SELECT * FROM tbl_primary_subject";
                                                                     $good1 = mysqli_query($con, $query1);
                                                                     $count = mysqli_num_rows($good1);
                                                                     echo $count;
                                                                  ?>
                                                         </span>
                                                         <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                                         <div class="clearfix"></div>
                                                     </div>
                                                 </a>
                                             </div>
                                         </div>
                                       </div>
                                     <!-- /.row -->

                                         </div>
                                         <hr>
                        <div class="row">
                        <div class="col-lg-8">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Manage subjects
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Subject code</th>
                                                    <th>Subject name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_primary_subject";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $subject_code=openssl_encrypt ($row['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo $row['subject_code']?></td>
                                                            <td><?php echo $row['subject_name']?></td>
                                                            <td><center>
                                                                <a title="Edit School" href="edit_leave?edit_leave=<?php echo $subject_code; ?>" onclick="return confirm('Are you sure! you are going to edit this School?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete School" href="controller/delete_school?delete=<?php echo $subject_code; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
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

                        <div class="col-lg-4 col-md-6">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-share fa-fw"></i> Quick Links
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="list-group">
                                        <a href="add_employee" class="list-group-item">
                                            <i class="fa fa-user fa-fw"></i> Add user
                                        </a>
                                        <a href="school" class="list-group-item">
                                            <i class="fa fa-bell fa-fw"></i> View entered schools
                                        </a>
                                        <a href="registered" class="list-group-item">
                                            <i class="fa fa-bar-chart-o fa-fw"></i> Manage students
                                        </a>
                                        <a href="subject" class="list-group-item">
                                            <i class="fa fa-random fa-fw"></i> Manage subject
                                        </a>
                                        <a href="result" class="list-group-item">
                                            <i class="fa fa-clipboard fa-fw"></i> Enter results
                                        </a>

                                    </div>
                                    <!-- /.list-group -->
                                </div>
                                <!-- /.panel-body -->
                    </div>
                        </div>
                <!-- /.container-fluid -->
            </div>
              <?php } ?>
            </div>

    </div>
  </div>
  </div> 
    </div>
    <!--Secondary (A-level) ends-->
  </div>
  </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->


            <?php
            if($_SESSION['type'] == "User"){
                ?>
            <div class="row">
               <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Leave History <a href="apply_leave" class="btn btn-sm btn-primary pull-right">Apply Leave</a>
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
            <?php } ?>

            <!-- /#page-wrapper -->
            <?php include('include/footer.php'); ?>

		</div>

	</div>

</div>
</body>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
	<script src="js/main.js"></script>
</html>
