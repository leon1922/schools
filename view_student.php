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
        .form-control{
            border-top: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border:2px solid #2a9df4;
            border-radius: 1em;
            font-family: inherit;
            font-size: 12px;
        }
    </style>
</head>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                           <h5 class="page-header" style="text-align: right;"><button type="button" class="btn btn-outline-secondary btn-sm" onclick="printDiv('print-content')" value="print a div!">PRINT DETAILS</button></h5>
                           
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
                                    $update = "UPDATE tbl_student_primary SET candidate_no = '".$candidate_no."', first_name = '".$first_name."', middle_name = '".$middle_name."', last_name = '".$last_name."'
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
                                          $student_id = $_GET['code'];
                                          $search = "SELECT * FROM tbl_student_registered WHERE student_id='$student_id'";
                                          $run_query = mysqli_query($con, $search);
                                          while($row = mysqli_fetch_array($run_query)){
                                          ?>
                                          <div id="print-content">
                                          <table class="table table- table-bordered">
                                              <tr>
                                                 <td colspan="7">
                                                 <center> <header>THE UNITED REPUBLIC OF TANZANIA <br>PRESIDENT'S OFFICE-RALG<br>KILAKALA SECONDARY SCHOOL<br>P.O.BOX 40 MOROGORO<br>STUDENT'S INFORMATION AS REGISTERED<br>Email:<i>kilakalass1957@gmail.com</i>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; Website:<i>www.kilakalasps.ac.tz </i></header>
                                                   </center>
                                                 
                                          </td>
                                    

                                          </tr>
                                               
                                               <tr>
                                                                <td colspan="7">
                                                                <img class="img-thumbnail img-responsive" width="150px" src="student_image/<?php echo $row['file']; ?>"><br>
                                                                   
                                                                </td>
                                                            </tr>
                                                          
                                              <tr>
                                              <td colspan="7" align="center" style="color: #2a9df4"><b>STUDENT DETAILS</b></td>
                                              </tr>
                                              <tr>
                                               <td colspan="5"><label>Full Name</label>
                                               <input class="form-control" type="text" value="<?php echo ucfirst(strtolower($row['first_name']))." ". ucfirst(strtolower($row['middle_name']))." ". ucfirst(strtolower($row['last_name']))?>" readonly>
                                               </td>
                                        
                                               <td><label>Gender</label>
                                               <input class="form-control" type="text" value="<?php echo $row['gender'] ?>" readonly>
                                               </td>
                                               <td><label>D.O.B</label>
                                               <input class="form-control" type="text" value="<?php echo $row['simage'] ?>" readonly>
                                               </td>
                                             
                                              </tr>
                                              <tr>
                                              <td colspan="7"><label>Previous School</label>
                                               <input class="form-control" type="text" value="<?php echo  ucfirst(strtolower($row['previous_school'] ))?>" readonly>
                                               </td>
                                              </tr>
                                              <tr>
                                              <td colspan="7" align="center" style="color: #2a9df4"><b>PARENT DETAILS</b></td>
                                              </tr>
                                              <tr>
                                               <td colspan="5"><label>Full Name</label>
                                               <input class="form-control" type="text" value="<?php echo ucfirst(strtolower($row['pfirst_name']))." ". ucfirst(strtolower($row['pmiddle_name']))." ". ucfirst(strtolower($row['plast_name']))?>" readonly>
                                               </td>
                                            
                                               <td><label>Occupation</label>
                                               <input class="form-control" type="text" value="<?php echo ucfirst(strtolower($row['occupation'] ))?>" readonly>
                                               </td>
                                               <td><label>P.O.Box</label>
                                               <input class="form-control" type="text" value="<?php echo $row['pbox'] ?>" readonly>
                                               </td>
                                               
                                               
                                              </tr>
                                              <tr>
                                              <td><label>Contacts</label>
                                               <input class="form-control" type="text" value="<?php echo $row['contacts'] ?>" readonly>
                                               </td>
                                              <td colspan="6"><label>Relationship</label>
                                               <input class="form-control" type="text" value="<?php echo ucfirst(strtolower($row['relationship'] ))?>" readonly>
                                               </td>
                                             </tr>
                                             
    
                                               </table>
                                          <?php } ?>
                                          </div>
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
        <script type="text/javascript">
     function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
 </script>