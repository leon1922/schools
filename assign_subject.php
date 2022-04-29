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
    </style>
    

</head>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="page-header" style="text-align: center;"> STUDENTS REGISTRATION -
                            <?php
                                include('include/config.php');
                                $school=openssl_decrypt ($_GET['no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $search = "SELECT * FROM tbl_school WHERE school_no = '$school'";
                                $run_query = mysqli_query($con, $search);
                                while($row = mysqli_fetch_array($run_query)){
                                    $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo strtoupper($row['school_no'] )." - ". strtoupper($row['school_name'] )." (".strtoupper($row['school_district']).")";?></td>
                                        </tr>
                                <?php } ?>
                            </h5>
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
                                    $check_student_subject = "SELECT * FROM tbl_student_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
                                $check_result = mysqli_query($con, $check_student_subject);
                                if(mysqli_num_rows($check_result)>0){
                                    echo "<script type=\"text/javascript\">
                                    alert(\"Failed: student was arleady assigned to that subject.\");
                                    </script>"; 
                                }else{
                                    $add = "INSERT INTO tbl_student_subject (student_id, subject_id) VALUES ('$student', '$subject_id')";
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
                                    $uncheck_student_subject = "SELECT * FROM tbl_student_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
                                    $check_result = mysqli_query($con, $uncheck_student_subject);
                                    if(mysqli_num_rows($check_result)>0){
                                        $query="DELETE FROM tbl_student_subject WHERE student_id = '$student' AND subject_id = '$subject_id'";
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
                ?>
                </div>
                    <!-- /.row -->
                  
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Manage registered students
                                    <!-- <a href="assign_subject?no=<?php echo $_GET['add']; ?>" class="btn btn-sm btn-primary pull-right">Assign subjects</a> -->
                                </div>
                                <!-- /.panel-heading -->
                                <form action="" method="POST">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <!-- id="dataTables-example" FOR TABLE DATA-->
                                            <thead>
                                                <tr>
                                                    <!-- <th>S/n</th> -->
                                                    <th rowspan="2">Candidate no.</th>
                                                    <th rowspan="2">Student name</th>
                                                    <th rowspan="2">Gender</th>
                                                    <th>
                                                    <select name="subject_id" class="form-control" required>
                                                                    <option disabled selected value="">-select subject-</option>
                                                                    <?php 
                                                                        $sql_department = "SELECT * FROM tbl_subject order by subject_name ASC";
                                                                        $department_data = mysqli_query($con,$sql_department);
                                                                        while($row = mysqli_fetch_assoc($department_data) ){
                                                                            $subject_id = $row['subject_id'];
                                                                            $subject_code = $row['subject_code'];
                                                                            $subject_name = $row['subject_name'];
                                                                        
                                                                            // Option
                                                                            echo "<option value='".$subject_id."'>".$subject_name."</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <input type="submit" class="btn btn-success btn-xs" name="assign_subject" value="asign">
                                                                <input type="submit" class="btn btn-danger btn-xs" name="unassign_subject" value="un-asign">
                                                    </th>
                                                    <th rowspan="2">Subject asigned</th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" id="checkAll" name="checkAll"> check all
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $school_no=openssl_decrypt ($_GET['no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM tbl_student WHERE school_no='$school_no'";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $student = $row['student_id'];
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <!-- <td class="center"><?php echo $i ?></td> -->
                                                            <td><?php echo $row['candidate_no']?></td>
                                                            <td><?php echo $row['first_name']." ".$row['middle_name']." ".$row['last_name']?></td>
                                                            <td><?php echo $row['gender']?></td>
                                                            <td><input type="checkbox" name="student_id[]" value="<?php echo $row['student_id']?>"></td>
                                                            <td>
                                                                <?php 
                                                                    $get_data = "SELECT * FROM tbl_student JOIN tbl_student_subject JOIN tbl_subject ON tbl_student.student_id = tbl_student_subject.student_id AND tbl_subject.subject_id = tbl_student_subject.subject_id WHERE tbl_student.student_id='$student'";
                                                                    $run = mysqli_query($con, $get_data);
                                                                    while($row2 = mysqli_fetch_array($run)){
                                                                        echo "<i style='font-size:11px;'>".$row2['subject_name']."</i>".",";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><center>
                                                                <a title="Edit School" href="edit_leave?edit_leave=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to edit this School?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete School" href="controller/delete_school?delete=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        
                                                    <?php $i++; } ?>
                                                    <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>

                                            </tbody>
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
