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
<head>
    <style>
        .input{
            border-top: none;
        }
    </style>
</head>

            <div id="page-wrapper">
                <div class="container-fluid">                    <div class="row">
                        <div class="col-lg-12">
                            <h5 style="text-align:center;" class="page-header">STUDENT REGISTRATION -
                            <?php
                                                    include('include/config.php');
                                                    $school=openssl_decrypt ($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM registered  WHERE school_no = '$school'";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){

                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td><?php echo  strtoupper($row['school_district'])." ";?></td>
                                                        </tr>

                                                    <?php $i++; } ?>
                            </h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
    // include "../include/config.php";

        if(isset($_POST['add_student'])){
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
            $school_no = mysqli_real_escape_string($con, $_POST['school_no']);
           
            $check_school = "SELECT * FROM tbl_student_registered WHERE candidate_no = '$candidate_no'";
            $check_result = mysqli_query($con, $check_school);
            if(mysqli_num_rows($check_result)>0){
                echo "<script type=\"text/javascript\">
                alert(\"Failed: student number arleady registered! student not added.\");
                </script>";
            }else{
                $add = "INSERT INTO tbl_student_registered (candidate_no, first_name, middle_name, last_name, gender, pfirst_name, pmiddle_name, plast_name, occupation, pbox, contacts, relationship,  previous_school, simage,  school_no)
                VALUES ('$candidate_no', '$first_name', '$middle_name', '$last_name', '$gender', '$pfirst_name', '$pmiddle_name', '$plast_name', '$occupation', '$pbox', '$contacts', '$relationship', '$previous_school', '$simage', '$school_no')";
                $send= mysqli_query($con, $add);
                if(!$send)
                {
                echo "<script type=\"text/javascript\">
                    alert(\"Failed: student not added.\");
                    </script>";
                }
                else {
                    echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        student was registered Successful
                                    </div></div>";
                }
            }
         }
?>

<!-- IMPORT STUDENTS -->
<?php
// Load the database configuration file
if(isset($_POST['import_student'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv',
    'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $candidate_no  = $line[0];
                $first_name  = $line[1];
                $middle_name  = $line[2];
                $last_name = $line[3];
                $gender = $line[4];
                $pfirst_name  = $line[5];
                $pmiddle_name  = $line[6];
                $plast_name = $line[7];
                $occupation = $line[8];
                $pbox = $line[9];
                $contacts = $line[10];
                $relationship = $line[11];
                $previous_school = $line[12];
                $simage = $line[13];
                $file = $line[14];
                $school_no=openssl_decrypt ($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);

                // Check whether member already exists in the database with the same email
                $prevQuery = "SELECT candidate_no FROM tbl_student_registered WHERE candidate_no = '".$line[0]."'";
                $prevResult = $con->query($prevQuery);

                if($prevResult->num_rows > 0){
                    // Update question data in the database
                    $con->query("UPDATE tbl_student_registered SET
                    candidate_no = '".$candidate_no."', first_name = '".$first_name."', middle_name = '".$middle_name."', last_name = '".$last_name."'
                    , gender = '".$gender."', pfirst_name = '".$pfirst_name."', pmiddle_name = '".$pmiddle_name."', plast_name = '".$plast_name."', occupation = '".$occupation."', pbox = '".$pbox."',  contacts = '".$contacts."', relationship = '".$relationship."', previous_school = '".$previous_school."', simage = '".$simage."',  file = '".$file."',  school_no = '".$school_no."' WHERE candidate_no = '".$candidate_no."'");
                }else{
                    // Insert question data in the database
                    $con->query("INSERT INTO tbl_student_registered (
                    candidate_no, first_name, middle_name, last_name, gender, pfirst_name, pmiddle_name, plast_name, occupation, pbox, contacts, relationship,  previous_school, simage, file,  school_no)
                   VALUES ('$candidate_no', '$first_name', '$middle_name', '$last_name', '$gender', '$pfirst_name', '$pmiddle_name', '$plast_name', '$occupation', '$pbox', '$contacts', '$relationship', '$previous_school', '$simage', '$file',  '$school_no')");
                }
            }

            // Close opened CSV file
            fclose($csvFile);


            // $qstring = 'Uploaded successful';
            echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            Uploaded successful
            </div></div>";
        }else{
            echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            Error while uploading
            </div></div>";
            // $qstring = 'Error while uploading';
        }
    }else{
        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
invalid file
</div></div>";
        // $qstring = 'invalid file';
    }
}

// header("Location: ../add_school".$qstring);

?>

                        <?php
                                    // if(!empty($_GET['status'])) {
                                    //     $show = $_GET['status'];
                                    //     echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                    //     <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    //     $show
                                    // </div></div>";
                                    // }
                                    if(!empty($_GET['del'])) {
                                        $show=openssl_decrypt ($_GET['del'], $ciphering, $decryption_key, $options, $decryption_iv);
                                        echo "<div class='col-md-12'><div class='alert alert-warning alert-dismissible'>
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
                                    Add students
                                    <a href="registered" class="btn btn-sm btn-primary pull-right">Manage students</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-6">
                                            <form action="" method="post" role="form">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" name="candidate_no" class="form-control" placeholder="admission number" minlength="10" maxlength="15" onkeyup="this.value = this.value.toUpperCase();" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="text" name="first_name" class="form-control" placeholder="first name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="middle_name" class="form-control" placeholder="middle name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="last_name" class="form-control" placeholder="last name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                    <select class="form-control" name="gender" required>
                                                                            <option disabled selected value="">Gender</option>
                                                                            <option>M</option>
                                                                            <option>F</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="pfirst_name" class="form-control" placeholder="parent first name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="pmiddle_name" class="form-control" placeholder="parent middle name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                    <input type="text" name="plast_name" class="form-control" placeholder="parent last name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="occupation" class="form-control" placeholder="occupation" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="pbox" class="form-control" placeholder="P.O.Box" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                    <input type="number" name="contacts" class="form-control" placeholder=" 0712345678" minlength="5" maxlength="10" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                    <select class="form-control" name="relationship" required>
                                                                            <option disabled selected value="">Relationship</option>
                                                                            <option>FATHER</option>
                                                                            <option>MOTHER</option>
                                                                            <option>BROTHER</option>
                                                                            <option>SISTER</option>
                                                                            <option>RELATIVE</option>
                                                                        </select>    
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                         <input type="text" name="previous_school" class="form-control" placeholder="previous school" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                 
                                                                    <input type="date" name="simage" class="form-control" placeholder=" 0712345678" minlength="5" maxlength="10" onkeyup="this.value = this.value.toUpperCase();" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                         <input type="text" name="school_no" value="<?php echo $school; ?>" hidden>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                <button name="add_student" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                                            </form>
                                        </div>

                                        <div class="col-lg-5 col-md-offset-1">
                                            <form action="" method="post" role="form" enctype="multipart/form-data">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                            <label>Upload students</label>
                                                                <input type="file" name="file" class="form-control" placeholder="Leave Type" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                                            </div>

                                                        </div>
                                                </div>
                                                <a href="include/add student.xls" class="btn btn-sm btn-primary"><span class="fa fa-download"></span> Download Template</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <button name="import_student" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Upload</button>
                                            </form>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Manage registered students
                                    <?php
                                        // $no = openssl_decrypt($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);
                                        // echo $no;
                                        // echo $_GET['add'];
                                    ?>
                                    <a href="#" class="btn btn-sm btn-primary pull-right">Assign subjects</a>
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Candidate no.</th>
                                                    <th>Student name</th>
                                                    <th>Gender</th>
                                                    <th>Contacts</th> 
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $school_no=openssl_decrypt ($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM tbl_student_registered WHERE school_no='$school_no' ORDER BY first_name ASC ";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){


                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo  strtoupper($row['candidate_no'])?></td>
                                                            <td><?php echo ucfirst(strtolower ($row['first_name']))." ".ucfirst(strtolower($row['middle_name']))." ".ucfirst(strtolower($row['last_name']))?></td>
                                                            <td><?php echo $row['gender']?></td>
                                                            <td><?php echo  strtoupper($row['contacts'])?></td>
                                                            <td><center>
                                                                <a title="Edit Student" href="edit_primary_student?code=<?php echo $row['student_id']?>" onclick="return confirm('Are you sure! you are going to edit this Student?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <!--<a title="Delete Student" href="controller/delete_primary_student?delete=<?php echo $student_id; ?>" onclick="return confirm('Are you sure! you are going to delete this Student?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>-->
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
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->


        <?php include('include/footer.php') ?>
