<?php
session_start();
if(!isset($_SESSION["type"]))
{
  header("location:login");
}
?>

<?php 
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;
  //HEADER PART OF THE DOCUMENT
    $output = "
    <head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
    face:Magneto;
  }
  th{
    background: yellow;
  }
  th, td {
    padding: 0.25rem;
    text-align: left;
    border: 1px solid #ccc;
  }
  tbody tr:hover {
    background: yellow;
  }

</style>
</head>
    
    <p class='MsoNormal' align='center' style='margin-bottom:0in;margin-bottom:.0001pt;
    text-align:center'><b style='mso-bidi-font-weight:normal'>
    <span style='font-size:8.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif'><o:p>&nbsp;</o:p></span></b></p>

    <p class='MsoNormal' align='center' style='margin-bottom:0in;margin-bottom:.0001pt;
    text-align:center'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;line-height:115%;font-family:&quot;Bookman Old Style&quot;,serif'>
    COMPANY / INSTUTION / ORGANIZATION NAME<o:p></o:p></span></b></p><br>
    <p class='MsoNormal' align='center' style='text-align:center;tab-stops:159.75pt'><b>
    <span style='font-size:11.5pt;font-family:&quot;Tahoma&quot;,sans-serif'>List of Employees with Approved Leaves</span></b><span style='font-size:11.5pt;font-family:&quot;Tahoma&quot;,sans-serif;mso-bidi-font-weight:
    bold'><o:p></o:p></span></p>
    
    <hr>

    
";

$output .= '<label>';
$output .= '<table id="customers">';
    $output .= '
    
  <tr>
    <th width="10px">S/No</th>
    <th>Employee Name</th>
    <th>Date</th>
    <th>To</th>
    <th>Contacts</th>
    <th>Leave Type</th>
  </tr>
  ';
include ("include/config.php");
$query = "SELECT * FROM employee JOIN leaves JOIN leave_type ON employee.employee_ID = leaves.employee_ID
AND leave_type.type_ID = leaves.type_ID  WHERE leaves.leave_status = 'Approved'";
$run = mysqli_query($con, $query);
$i = 1;
while($row = mysqli_fetch_array($run))
{
  $output .='
  <tbody>
  <tr>
    <td>'.$i++.'</td>
    <td>'.$row["employee_fname"].' '.$row["employee_lname"].'</td>
    <td>'.$row["leave_from"].' to '.$row["leave_to"].'</td>
    <td>'.$row["to_place"].'</td>
    <td>'.$row["phone_number"].'</td>
    <td>'.$row["type_name"].'</td>
    
  </tr>
  </tbody>
  ';
}
$output .= '</table>';
$output .= '</label>';


    $output .= "
        <hr>        
       
    ";


// use dompdf class
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new Dompdf($options);
$contxt = stream_context_create([ 
    'ssl' => [ 
        'verify_peer' => FALSE, 
        'verify_peer_name' => FALSE,
        'allow_self_signed'=> TRUE
    ] 
]);
$dompdf->setHttpContext($contxt);

$dompdf->loadHtml($output);

$dompdf->setPaper('A4', 'potrait');

//render the HTML as PDF
$dompdf->render();

$dompdf->stream("Employee Leave Report",array("Attachment" => false));

?>