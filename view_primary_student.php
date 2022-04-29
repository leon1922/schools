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
                        <h5 class="page-header" style="text-align: right;"><button type="button" class="btn btn-outline-secondary btn-sm" onclick="printDiv('print-content')" value="print a div!">PRINT DETAILS</button></h5>  
                           
                        </div>
                        <!-- /.col-lg-12 -->

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">


                            <div id="print-content">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="example" >
                                       
                                            <thead>
                                            <div class="col-lg-12">
                            
                            <h5 style="text-align:center;">STUDENTS REGISTERED -
                            <?php
                                                    include('include/config.php');
                                                    $school=openssl_decrypt ($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM registered WHERE school_no = '$school'";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){

                                                        $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                        ?>
                                                  
                                                            <?php echo  strtoupper($row['school_district']);?>
                                                  
                                                       

                                                    <?php $i++; } ?>
                            </h5>
                        </div>
                                                
                                                <tr>
                                                    <th>S/n</th>
                                                    <th>Candidate no.</th>
                                                    <th>First Name</th>
                                                    <th>Middle Name</th>
                                                    <th>Last Name</th>
                                                    <th>Gender</th>
                                                    <th>Contacts</th>
                                                    <th>Relationship</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                <?php
                                                    include('include/config.php');
                                                    $school_no=openssl_decrypt ($_GET['add'], $ciphering, $decryption_key, $options, $decryption_iv);
                                                    $search = "SELECT * FROM tbl_student_registered WHERE school_no='$school_no' ORDER BY first_name, middle_name, last_name ASC";
                                                    $run_query = mysqli_query($con, $search);
                                                    $i = 1;
                                                    while($row = mysqli_fetch_array($run_query)){


                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo $i ?></td>
                                                            <td><?php echo  strtoupper($row['candidate_no'])?></td>
                                                            <td><?php echo  strtoupper($row['first_name'])?></td>
                                                            <td><?php echo  strtoupper($row['middle_name'])?></td>
                                                            <td><?php echo  strtoupper($row['last_name'])?></td>
                                                            <td><?php echo $row['gender']?></td>
                                                            <td><?php echo  strtoupper($row['contacts'])?></td>
                                                            <td><?php echo  strtoupper($row['relationship'])?></td> 
                                                            <td><center>
                                                                <a title="View Student details" href="view_student?code=<?php echo $row['student_id']?>" class=""><i class="fa fa-eye" style="color:blue;"></i></a>
                                                                <!--<a title="Delete Student" href="controller/delete_primary_student?delete=<?php echo $student_id; ?>" onclick="return confirm('Are you sure! you are going to delete this Student?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>-->
                                                                </center>
                                                            </td>
                                                        </tr>

                                                    <?php $i++; } ?>
                                            </tbody>
                                         </div>
                                        </table>
                                    </div>
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
        <script type="text/javascript">
     function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
$('#example').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
      } );
 </script>
