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
                           <h5 class="page-header" style="text-align: center;">EDIT EXAMINATION REGISTERED</h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    include ('include/config.php');
                                    $school_id = $_GET['code'];
                                    if(isset($_POST['submit'])){
                                    $school_no = mysqli_real_escape_string($con, $_POST['school_no']);
                                    $school_name = mysqli_real_escape_string($con, $_POST['school_name']);
                                    $school_district = mysqli_real_escape_string($con, $_POST['school_district']);
                                    $school_type = mysqli_real_escape_string($con, $_POST['school_type']);
                                    $update = "UPDATE tbl_school_p SET school_no = '$school_no', school_name= '$school_name',
                                    school_district = '$school_district', school_type = '$school_type' WHERE school_id='$school_id'";
                                    $update_query = mysqli_query($con, $update);
                                    if($update_query){
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
                                }
                                    ?>
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-12">
                                        <?php
                                          include('include/config.php');
                                          $school_id = $_GET['code'];
                                          $search = "SELECT * FROM tbl_school_p WHERE school_id='$school_id'";
                                          $run_query = mysqli_query($con, $search);
                                          while($row = mysqli_fetch_array($run_query)){
                                          ?>
                                            <form role="form" method="post" action="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" value="<?php echo $row['school_no'] ?>" name="school_no" class="form-control" onkeyup="this.value = this.value.toUpperCase();"  placeholder="Exam No:" readonly>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="text" value="<?php echo $row['school_name'] ?>" name="school_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Exam Name" readonly>
                                                            </div>
                                                            <div class="row form-group">
                                                                <select class="form-control" name="school_type" required>
                                                                <option disabled selected value=""><?php echo $row['school_type'] ?></option>
                                                                <option value="INSIDE">INSIDE</option>
                                                                <option value="OUTSIDE">OUTSIDE</option>
                                                                <option value="MEK">MEK</option>
                                                                <option value="KSSEB">KSSEB</option>
                                                            </select>
                                                            </div>
                                                            <div class="row form-group">

                                                            <select class="form-control" name="school_district" required>
                                                             <option disabled selected value=""><?php echo $row['school_district'] ?></option>
                                                             <option>FORM I</option>
                                                             <option>FORM II</option>
                                                             <option>FORM III</option>
                                                             <option>FORM IV</option>
                                                       
                                                         </select>
                                                            </div>
                                                            
                                                            <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
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

        <?php include('include/footer.php') ?>