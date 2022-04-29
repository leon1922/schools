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
                           <h5 class="page-header" style="text-align: center;">EDIT PRIMARY SCHOOL SUBJECT</h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    include ('include/config.php');
                                    $subject_id = $_GET['code'];
                                    if(isset($_POST['submit'])){
                                    $subject_code = mysqli_real_escape_string($con, $_POST['subject_code']);
                                    $subject_name = mysqli_real_escape_string($con, $_POST['subject_name']);
                                    $update = "UPDATE tbl_primary_subject SET subject_code = '$subject_code', subject_name= '$subject_name'
                                     WHERE subject_id='$subject_id'";
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
                                    Edit Primary Subjects Registered
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-12">
                                        <?php
                                          include('include/config.php');
                                          $subject_id = $_GET['code'];
                                          $search = "SELECT * FROM tbl_primary_subject WHERE subject_id='$subject_id'";
                                          $run_query = mysqli_query($con, $search);
                                          while($row = mysqli_fetch_array($run_query)){
                                          ?>
                                            <form role="form" method="post" action="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" value="<?php echo $row['subject_code'] ?>" name="subject_code" class="form-control" onkeyup="this.value = this.value.toUpperCase();"  placeholder="Subject Code:" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="text" value="<?php echo $row['subject_name'] ?>" name="subject_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Subject Name" required>
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