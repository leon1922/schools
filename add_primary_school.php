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
                            <h5 class="page-header" style="text-align: center;">ADD EXAMINATION</h5>
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
                                    ADD EXAM
                                    <a href="school_primary" class="btn btn-sm btn-primary pull-right">Manage Exams</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- /.col-lg-6 (nested) -->
                                        <div class="col-lg-6">
                                            <form action="controller/add_primary_school.php" method="post" role="form">
                                                        <div class="col-md-12">
                                                            <div class="row form-group">
                                                                <input type="text" name="school_no" class="form-control" placeholder="Examination number" minlength="5" maxlength="25" onkeyup="this.value = this.value.toUpperCase();" required>
                                                            </div>
                                                            <div class="row form-group">
                                                                <input type="text" name="school_name" class="form-control" placeholder="Examination name" onkeyup="this.value = this.value.toUpperCase();" required>
                                                            </div>
                                                            <div class="row form-group">
                                                            <select class="form-control" name="class_level" required>
                                                                <option disabled selected value="">Class Level</option>
                                                                <option value="a_level">A-LEVEL</option>
                                                                <option value="o_level">O-LEVEL</option>
        
                                                            </select>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                <select class="form-control" name="school_type" required>
                                                                <option disabled selected value="">Examination Type</option>
                                                                <option value="INSIDE">INSIDE</option>
                                                                <option value="OUTSIDE">OUTSIDE</option>
                                                                <option value="MEK">MEK</option>
                                                                <option value="KSSEB">KSSEB</option>
                                                            </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                             <select class="form-control" name="school_district" required>
                                                             <option disabled selected value="">Select Class</option>
                                                             <option>FORM I</option>
                                                             <option>FORM II</option>
                                                             <option>FORM III</option>
                                                             <option>FORM IV</option>
                                                             <option>FORM V PCB</option>
                                                             <option>FORM V PCM</option>
                                                             <option>FORM V CBG</option>
                                                             <option>FORM V HGL</option>
                                                             <option>FORM VI PCB</option>
                                                             <option>FORM VI PCM</option>
                                                             <option>FORM VI CBG</option>
                                                             <option>FORM VI HGL</option>
                                                       
                                                         </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                <button name="add_school" class="btn btn-sm btn-primary"><span class="fa fa-save"></span> Save</button>
                                            </form>
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
                                    Manage registered schools
                                    <!-- <a href="add_school" class="btn btn-sm btn-primary pull-right">Add school</a> -->
                                </div>
                                <!-- /.panel-heading -->

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Exam no.</th>
                                                    <th>Exam name</th>
                                                    <th>Exam type</th>
                                                    <th>Class</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_school_p ORDER BY school_district ASC";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){

                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                        <tr class="odd gradeX">
                                                                                                                   <td class="center"><?php echo $i ?></td>
                                                                                                                   <td><?php echo strtoupper($row['school_no'])?></td>
                                                                                                                   <td><?php echo strtoupper ($row['school_name'])?></td>
                                                                                                                   <td><?php echo strtoupper ($row['school_type'])?></td>
                                                                                                                   <td><?php echo strtoupper ($row['school_district'])?></td>
                                                                                                                   <td><center>
                                                                                                                       <a title="Edit Exam" href="edit_primary_schools?code=<?php echo $row['school_id']?>" onclick="return confirm('Are you sure! you are going to edit this Exam?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                                                                       <a title="Delete Exam" href="controller/delete_primary_school?delete=<?php echo $row['school_id']?>" onclick="return confirm('Are you sure! you are going to delete this Exam?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
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