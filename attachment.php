
<?php 
session_start();
if(!isset($_SESSION["type"]))
{
	header("location:login");
} 

  include('include/config.php');
  // Store the file name into variable 

  $attach = $_GET['take'];
  $id = $_GET['id'];
  //echo $file;
  $search = "SELECT * FROM leaves WHERE attachment = '$attach' AND leave_ID='$id'";
  $run = mysqli_query($con, $search);
  while($row = mysqli_fetch_array($run)){
      $file = "employee_image/".$row['attachment'];
  }
  $filename = "employee_image/".$row['attachment'];
    
  // Header content type 
  header('Content-type: application/pdf'); 
    
  header('Content-Disposition: inline; filename="' . $filename . '"'); 
    
  header('Content-Transfer-Encoding: binary'); 
    
  header('Accept-Ranges: bytes'); 
    
  // Read the file 
  @readfile($file); 
    
  ?> 