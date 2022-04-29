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
<!DOCTYPE html>
<html>
<head>
	<title>table of trial in export data</title>
<script src="js/jquery.min.js"></script>	
<link rel="stylesheet" src="js/jquery.dataTables.min.css">
<link rel="stylesheet" src="js/buttons.dataTables.min.css">


<script src="js/jquery.dataTables.min.js"></script> 


<script src="js/dataTables.buttons.min.js"></script> 
<script src="js/buttons.flash.min.js"></script> 
<script src="js/jszip.min.js"></script> 
<script src="js/pdfmake.min.js"></script> 
<script src="js/vfs_fonts.js"></script> 
<script src="js/buttons.html5.min.js"></script> 
<script src="js/buttons.print.min.js"></script>

<script type="text/javascript">
$(document).ready(function() 
{ 
    $('#example').DataTable( 
    { 
        dom: 'Blfrtip',
    } );

} );
</script>
</head>
<body>
<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
                        <div class="col-lg-12">
                            <h5 class="page-header" style="text-align: center;">ALL PRIMARY SCHOOLS REGISTERED</h5>
                        </div>
                        <!-- /.col-lg-12 -->
                        <?php
                                    if(!empty($_GET['del'])) {
                                        $show = $_GET['del'];
                                        echo "<div class='col-md-12'><div class='alert alert-danger alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        $show
                                    </div></div>";
                                    }
                                    ?>
                    </div>
<table id="example" class="table table-striped table-bordered table-hover" style="width:100%;">
        
             <thead>
            <tr>
                <th>S/n</th>
                <th>Center no.</th>
                <th>School name</th>
                <th>School type</th>
                <th>District</th>
                <th></th>
            </tr>
            </thead>
        
        <tbody>
            <?php
                                                    include('include/config.php');
                                                    $search = "SELECT * FROM tbl_school_p";
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
                                                                <a title="Edit School" href="edit_primary_schools?code=<?php echo $row['school_id']?>" onclick="return confirm('Are you sure! you are going to edit this School?');" class=""><i class="fa fa-edit" style="color:green;"></i></a>
                                                                <a title="Delete School" href="controller/delete_primary_school?delete=<?php echo $row['school_id']?>" onclick="return confirm('Are you sure! you are going to delete this School?');" class=""><i class="fa fa-trash" style="color:red;"></i></a>
                                                                </center>

                                                            </td>
                                                        </tr>
                                                        
                                                    <?php $i++; } ?>
                                            </tbody>
        </tbody>
    </table>
   </div> 
</div>
</body>
<?php include('include/footer.php'); ?>
</html>