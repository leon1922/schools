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
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }

        /* Firefox */
        input[type=number] {
          -moz-appearance:textfield;
        }
    </style>


</head>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="page-header" style="text-align: center;"> ENTER MARKS -
                            <?php
                                include('include/config.php');
                                $school=openssl_decrypt ($_GET['no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $search = "SELECT * FROM tbl_school_p WHERE school_no = '$school'";
                                $run_query = mysqli_query($con, $search);
                                while($row = mysqli_fetch_array($run_query)){
                                    $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo strtoupper( $row['school_name'])  ."  ".strtoupper($row['school_district'])."";?></td>
                                        </tr>
                                <?php } ?>
                            </h4>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class="row">
                    <?php
                        include "include/config.php";
                        if(isset($_POST['assign_subject'])){
                            // $student_id = $_POST['student_id'];
                            $subject_id = mysqli_real_escape_string($con, $_POST['subject_id']);
                            if(empty($_POST["student_id"])){
                                echo "<div class='col-md-12'><div class='alert alert-danger alert-dismissible'>
                                         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                        No student selected, select at least one student
                                        </div></div>";
                            }else{
                                foreach($_POST["student_id"] as $student)
                                {
                                    $check_student_subject = "SELECT * FROM tbl_student_primary_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
                                $check_result = mysqli_query($con, $check_student_subject);
                                if(mysqli_num_rows($check_result)>0){
                                    echo "<script type=\"text/javascript\">
                                    alert(\"Failed: student was arleady assigned to that subject.\");
                                    </script>";
                                }else{
                                    $add = "INSERT INTO tbl_student_primary_subject (student_id, subject_id) VALUES ('$student', '$subject_id')";
                                    $send= mysqli_query($con, $add);
                                    if(!$send)
                                    {
                                    echo "<script type=\"text/javascript\">
                                        alert(\"Failed: subject not assiigned.\");
                                        </script>";
                                    }
                                    else {
                                        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                            subject was assigned Successful
                                                        </div></div>";
                                    }
                                }
                                }
                            }
                        }

                        if(isset($_POST['unassign_subject'])){
                            // $student_id = $_POST['student_id'];
                            $subject_id = mysqli_real_escape_string($con, $_POST['subject_id']);
                            if(empty($_POST["student_id"])){
                                echo "<div class='col-md-12'><div class='alert alert-danger alert-dismissible'>
                                         <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                        No student selected, select students to un-asign subjects
                                        </div></div>";
                            }else{
                                foreach($_POST["student_id"] as $student)
                                {
                                    $uncheck_student_subject = "SELECT * FROM tbl_student_primary_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
                                    $check_result = mysqli_query($con, $uncheck_student_subject);
                                    if(mysqli_num_rows($check_result)>0){
                                        $query="DELETE FROM tbl_student_primary_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
                                        $run=mysqli_query($con, $query);
                                        if($run==TRUE){
                                            echo "<div class='col-md-12'><div class='alert alert-warning alert-dismissible'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    subject was un-assigned Successful
                                                </div></div>";
                                        }
                                    }else{
                                            echo "<div class='col-md-12'><div class='alert alert-primary alert-dismissible'>
                                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                               selected student(s) was not assigned to a selected subject
                                                            </div></div>";
                                    }
                                    }
                                }
                        }

                        if(isset($_POST['insert_marks'])){
                            // echo "<pre>";
                            // print_r($_POST);
                            // echo "</pre>";

                            $subject_code=@openssl_decrypt ($_GET['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                            $find_subject_id = "SELECT * FROM tbl_primary_subject WHERE subject_code = '$subject_code'";
                            $true_chek = mysqli_query($con, $find_subject_id);
                            while($check = mysqli_fetch_array($true_chek)){
                                $subject = $check['subject_id'];
                            }
                                $countStudentID = $_POST["student_subject_id"];
                                $try = count($countStudentID);
                                $newmarks = $_POST["marks"];
                                for ($i=0; $i < $try; $i++) {
                                    $newmarks1=$newmarks[$i];
                                    $countStudentID1 = $countStudentID[$i];
                                    $add_mark = "UPDATE tbl_student_primary_subject SET marks ='$newmarks1' WHERE student_subject_id = '$countStudentID1' ";
                                    $send = mysqli_query($con, $add_mark);

                                }
                                if(!$send){
                                    echo "<script type=\"text/javascript\">
                                        alert(\"Failed: marks not added.\");
                                        </script>";
                                }else {
                                    echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                Marks added
                                            </div></div>";
                                }

                        }
                ?>
                </div>
                    <!-- /.row -->
                    <!-- /.row -->
              
              <div class="row">
                    <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                     <table class="table table-bordered">
                                        <tr>
                                                        <td>SUBJECTS</td>
                                       <!-- <td>students registered</td> -->
                                        </tr>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT  distinct tbl_school_p.school_no, tbl_school_p.school_name, tbl_primary_subject.subject_code, tbl_primary_subject.subject_name FROM tbl_school_p JOIN tbl_student JOIN tbl_primary_subject JOIN tbl_student_primary_subject ON
                                                    tbl_school_p.school_no = tbl_student.school_no AND tbl_student.student_id = tbl_student_primary_subject.student_id AND
                                                     tbl_primary_subject.subject_id = tbl_student_primary_subject.subject_id WHERE tbl_school_p.school_no='$school'";
                                                    $run_query = mysqli_query($con, $search);
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $subject_code=openssl_encrypt ($row['subject_code'], $ciphering, $encryption_key, $options, $encryption_iv);
                                                        $test=openssl_encrypt ($school, $ciphering, $encryption_key, $options, $encryption_iv);
                                                        ?>
                                                            <tr>
                                                                <td><a href="enter_primaryresult?subject_code=<?php echo $subject_code.'&no='.$test ; ?>"><?php echo $row['subject_name'];?></a></td>
                                                               <!-- <td>
                                                                    <?php
                                                                            $school_count = "SELECT  * FROM tbl_school_p JOIN tbl_student_registered JOIN tbl_primary_subject JOIN tbl_student_primary_subject ON
                                                                            tbl_school_p.school_no = tbl_student_registered.school_no AND tbl_student_registered.student_id = tbl_student_primary_subject.student_id AND
                                                                             tbl_primary_subject.subject_id = tbl_student_primary_subject.subject_id WHERE tbl_primary_subject.subject_code='$subject_code'";
                                                                            $count_query = mysqli_query($con, $school_count);
                                                                            echo mysqli_num_rows($count_query);
                                                                        ?>
                                                                </td> -->
                                                            </tr>

                                                    <?php  } ?>
                                       </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="text-align: center;">
                                <?php
                                     include('include/config.php');
                                     $subject_code=@openssl_decrypt ($_GET['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                     $find = "SELECT DISTINCT subject_name FROM tbl_primary_subject WHERE subject_code = '$subject_code'";
                                     $go = mysqli_query($con, $find);
                                     while($row11 = mysqli_fetch_array($go)){
                                        echo strtoupper($row11['subject_name']);
                                     }

                                  ?>
                                </div>
                                <!-- /.panel-heading -->
                                <form action="" method="POST">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <!--<th>Reg No.</th>-->
                                                    <th>Student name</th>
                                                    <!-- <th></th> -->
                                                    <th>
                                                        Marks<input type="submit" class="btn btn-success btn-xs pull-right" name="insert_marks" value="Save" required>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $subject_code=@openssl_decrypt ($_GET['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $school_no=openssl_decrypt ($_GET['no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    // old search query
                                                    // $search = "SELECT * FROM tbl_student_registered JOIN tbl_primary_subject JOIN tbl_student_primary_subject ON tbl_student_registered.student_id = tbl_student_primary_subject.student_id AND tbl_primary_subject.subject_id = tbl_student_primary_subject.subject_id

                                                    //new search query
                                                    $search = "SELECT * FROM tbl_student_primary_subject
                                                            JOIN tbl_primary_subject ON tbl_primary_subject.subject_id = tbl_student_primary_subject.subject_id
                                                            JOIN tbl_student  ON tbl_student.student_id = tbl_student_primary_subject.student_id
                                                        WHERE
                                                            tbl_student.school_no='$school_no' AND
                                                            tbl_primary_subject.subject_code='$subject_code' ORDER BY first_name, middle_name, last_name";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_assoc($run_query)){
                                                        $student = $row['student_id'];
                                                        $st = $row["student_subject_id"];
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <!--<td><?php echo $row['candidate_no']?></td>-->
                                                            <td><?php echo $row['first_name']." ".$row['middle_name']." ".$row['last_name']?></td>
                                                            <input type="hidden" name="student_subject_id[]" value="<?php echo $row['student_subject_id']?>">
                                                            <td><input type="number" min="0" max="100" step="any" name="marks[]" class="form-control" style="width:65px;"  value="<?php echo $row['marks']?>"></td>
                                                            </tr>

                                                    <?php $i++; } ?>
                                                    <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>S/n</th>
                                                   <!-- <th>Candidate no.</th>-->
                                                    <th>Student name</th>
                                                    <!-- <th></th> -->
                                                    <th>
                                                        Marks<input type="submit" class="btn btn-success btn-xs pull-right" name="insert_marks" value="Save">
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

            <script type="text/javascript">
                $("#checkAll").click(function(){
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });
        </script>
        <?php include('include/footer.php') ?>
