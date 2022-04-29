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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                           <h5 class="page-header" style="text-align: center;">ADD EXAMINATION SUBJECTS</h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    if(!empty($_GET['success'])) {

                                        $decryption=openssl_decrypt ($_GET['success'], $ciphering, $decryption_key, $options, $decryption_iv);
                                            // $show = $_GET['success'];
                                        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        $decryption
                                    </div></div>";
                                    }
                                    if(!empty($_GET['status'])) {
                                        $show = $_GET['status'];
                                        // $show=openssl_decrypt ($_GET['status'], $ciphering, $decryption_key, $options, $decryption_iv);
                                        echo "<div class='col-md-12'><div class='alert alert-info alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        $show
                                    </div></div>";
                                    }
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
                                    Add Exam Subject
                                    <a href="primarysubject" class="btn btn-sm btn-primary pull-right">Manage subjects</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-6">
                                            <form action="controller/add_primarysubject.php" method="post" role="form">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" name="subject_code" class="form-control" placeholder="subject code" maxlength="35" onkeyup="this.value = this.value.toUpperCase();" required>
                                                            </div>
                                                            <div class="row form-group">
                                                            <input class="form-control" list="datalistOptions" id="exampleDataList" name="subject_name" placeholder="Type to search Subject..." autocomplete="off">
                                                            <datalist id="datalistOptions">
                                                            <option value="PHYSICS">
                                                            <option value="CIVICS">
                                                            <option value="ENGLISH">
                                                            <option value="KISWAHILI">
                                                            <option value="FRENCH">
                                                            <option value="CHINESE">
                                                            <option value="ICS">
                                                            <option value="FOOD & NUTRTITION">
                                                            <option value="B/KEEPING">
                                                            <option value="COMMERCE">
                                                            <option value="CHEMISTRY">
                                                            <option value="BIOLOGY">
                                                            <option value="B/MATHEMATICS">  
                                                            <option value="GEOGRAPHY"> 
                                                            <option value="BAM">
                                                            <option value="G/STUDIES">
                                                            <option value="ISLAMIC">
                                                            <option value="HISTORY">
                                                            <option value="ENGLISH LANGUAGE">
                                                            <option value="A/MATHS">
                                                            </datalist>     
                                                            </div>
                                                            <div class="row form-group">
                                                                    <select class="form-control" name="class_level" required>
                                                                            <option disabled selected value="">Class level</option>
                                                                            <option  value="a_level">A-level</option>
                                                                            <option  value="o_level">O-level</option>
                                                                        </select>    
                                                            </div>
                                                            <div class="row form-group">
                                                            <select name="school_no" class="form-control" required>
                                                                    <option disabled selected value="">-select examination no-</option>
                                                                    <?php
                                                                        $sql_department = "SELECT * FROM tbl_school_p  order by school_district ASC";
                                                                        $department_data = mysqli_query($con,$sql_department);
                                                                        while($row = mysqli_fetch_assoc($department_data) ){
                                                                            $school_id = $row['school_id'];
                                                                            $school_no = $row['school_no']; 
                                                                            $school_name = $row['school_name'];
                                                                            $school_district = $row['school_district'];
                                                                            $school_type = $row['school_type'];
                                                                            $class_level = $row['class_level'];

                                                                            // Option
                                                                            echo "<option value='".$school_no."'>".$school_no."</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="date" name="subject_date" class="form-control" placeholder="subject date" onkeyup="this.value = this.value.toUpperCase();" required>
                                                            </div>
                                                        </div>
                                                <button name="add_subject" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                                            </form>
                                        </div>

                                        <!--<div class="col-lg-5 col-md-offset-1">
                                            <form action="controller/import_subject.php" method="post" role="form" enctype="multipart/form-data">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                            <label>Upload subjects</label>
                                                                <input type="file" name="file" class="form-control" placeholder="Leave Type" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                                            </div>
                                                            <input type="text" name="token" value="<?=$_SESSION['token'] ?>" hidden>
                                                        </div>
                                                </div>
                                                <button name="import_subject" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Upload</button>
                                            </form>
                                        </div>-->
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
                                    Manage registered Exams
                                    <!-- <a href="add_school" class="btn btn-sm btn-primary pull-right">Add school</a> -->
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Subject code</th>
                                                    <th>Subject name</th>
                                                    <th>Subject Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_primary_subject order by subject_code ASC";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){
                                                        $subject_code=openssl_encrypt ($row['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo $row['subject_code']?></td>
                                                            <td><?php echo strtoupper( $row['subject_name'])?></td>
                                                            <td><?php echo $row['subject_date']?></td>
                                                            <td><center>
                                                                <a title="Edit Subject" href="edit_primary_subject?code=<?php echo $row['subject_id']?>" onclick="return confirm('Are you sure! you are going to edit this Subject?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <!--<a title="Delete School" href="controller/delete_school?delete=<?php echo $school_no; ?>" onclick="return confirm('Are you sure! you are going to delete this Leave type?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>-->
                                                                </center>
                                                            </>
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