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
                           <h5 class="page-header" style="text-align: center;">EDIT  STUDENTS REGISTERED</h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    include ('include/config.php');
                                    $student_id = $_GET['code'];
                                    if(isset($_POST['submit'])){
                                    $candidate_no = mysqli_real_escape_string($con, $_POST['candidate_no']);
                                    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
                                    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
                                    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
                                    $gender = mysqli_real_escape_string($con, $_POST['gender']);
                                    $pfirst_name = mysqli_real_escape_string($con, $_POST['pfirst_name']);
                                    $pmiddle_name = mysqli_real_escape_string($con, $_POST['pmiddle_name']);
                                    $plast_name = mysqli_real_escape_string($con, $_POST['plast_name']);
                                    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
                                    $pbox = mysqli_real_escape_string($con, $_POST['pbox']);
                                    $contacts = mysqli_real_escape_string($con, $_POST['contacts']);
                                    $relationship = mysqli_real_escape_string($con, $_POST['relationship']);
                                    $previous_school = mysqli_real_escape_string($con, $_POST['previous_school']);
                                    $simage = mysqli_real_escape_string($con, $_POST['simage']);
                                    $update = "UPDATE tbl_student_registered SET candidate_no = '".$candidate_no."', first_name = '".$first_name."', middle_name = '".$middle_name."', last_name = '".$last_name."'
                                    , gender = '".$gender."', pfirst_name = '".$pfirst_name."', pmiddle_name = '".$pmiddle_name."', plast_name = '".$plast_name."', occupation = '".$occupation."', pbox = '".$pbox."',  contacts = '".$contacts."', relationship = '".$relationship."', previous_school = '".$previous_school."', simage = '".$simage."'  WHERE student_id='$student_id'";
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
                                          $search = "SELECT * FROM tbl_student_registered WHERE student_id='$student_id'";
                                          $run_query = mysqli_query($con, $search);
                                          while($row = mysqli_fetch_array($run_query)){
                                          ?>
                                            <form role="form" method="post" action="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" value="<?php echo $row['candidate_no'] ?>" name="candidate_no" class="form-control" onkeyup="this.value = this.value.toUpperCase();"  placeholder="Candidate No:" readonly>
                                                            </div>
                                                            <div class="row form-group">
                                                            <div class="row">
                                                            <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['first_name'] ?>" name="first_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="First Name" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['middle_name'] ?>" name="middle_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Middle Name" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['last_name'] ?>" name="last_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Last Name" required>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            <div class="row form-group">
                                                            <div class="row">
                                                            <div class="col-md-4">
                                                            <select class="form-control" name="gender" required>
                                                             <option disabled selected value=""><?php echo $row['gender'] ?></option>
                                                             <option>F</option>
                                                             <option>M</option>

                                                         </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['pfirst_name'] ?>" name="pfirst_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="parent first name">
                                                            </div>
                                                            <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['pmiddle_name'] ?>" name="pmiddle_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="parent middle name">
                                                            </div>
                                                            </div>
                                                         </div>
                                                         <div class="row form-group">
                                                         <div class="row">
                                                         <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['plast_name'] ?>" name="plast_name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="parent last name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['occupation'] ?>" name="occupation" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="occupation">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['pbox'] ?>" name="pbox" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="P.O.Box">
                                                        </div>


                                                         </div>
                                                        
                                                    </div>
                                                    <div class="row form-group">
                                                         <div class="row">
                                                         <div class="col-md-4">
                                                         <input type="text" value="<?php echo $row['contacts'] ?>" name="contacts" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="contacts">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['relationship'] ?>" name="relationship" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="relationship">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="<?php echo $row['previous_school'] ?>" name="previous_school" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Previous School">
                                                        </div>


                                                         </div>
                                                        
                                                    </div>
                                                           
                                                            <div class="row form-group">
                                                             <input type="text" value="<?php echo $row['simage'] ?>" name="simage" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="simage" readonly>
                                                         </div

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