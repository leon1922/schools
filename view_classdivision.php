<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" type="text/css" href="print.css" media="print">
<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<style type="text/css">
      table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  background-color: white;
  align-content: center;
  align-self: center;
}

td, th {
  border: 2px solid black;
  text-align: left;
  padding: 4px;
  align-content: center;
}
    </style>
</head>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->



		<div id="loader-wrapper">
			<div id="loader"></div>

			<div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

		</div>

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
                        <h5 class="page-header" style="text-align: right;"> <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printDiv('print-content')" value="print a div!">PRINT RESULTS</button></h5>  
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                
                                <!-- /.panel-heading -->
                                <?php
                                $school_no=openssl_decrypt ($_GET['view'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $student_rt = [];

$sql_students = "SELECT * FROM `tbl_student` WHERE school_no='$school_no' ORDER BY first_name";
$sql_subjects = "SELECT * FROM `tbl_primary_subject` WHERE school_no='$school_no'";
$subjects = $con->query($sql_subjects);
$students = $con->query($sql_students);


foreach ($students as $key1 => $student) {
    $student_reslt = [];
    $total_marks = 0;
    $avg_grade   = 0;
    $avg_marks   = 0;
    $avg_remark  = '';
    $grade       = '';
    $remark      = '';
    $pt          = 0;
    $divisions = '';

    $sudentid = $student['student_id'];
    $subjects_results = [];
    foreach ($subjects as $subject_result_key => $subject) {

        $tbl_student_subject_query = "SELECT * FROM tbl_student_primary_subject
            -- INNER JOIN tbl_student_registered ON tbl_student_registered.student_id = tbl_student_registered_subject.student_id
            INNER JOIN tbl_primary_subject ON tbl_primary_subject.subject_id = tbl_student_primary_subject.subject_id
            WHERE tbl_student_primary_subject.student_id='$sudentid' ";
        $results = $con->query($tbl_student_subject_query);
        $total_rows = $results->num_rows;
        $subject_marks = "-";
        foreach ($results as $key => $result) {
            if ($result['subject_id'] == $subject['subject_id']) {
                $subject_marks = $result['marks'];
            }
        }
        if ($subject_marks !== "-") {
            $total_marks += $subject_marks;
            $avg_marks    = $total_marks/ $total_rows;
        }
        $subjects_results[$subject_result_key] = [
            'subject_name'  => $subject['subject_name'],
            'subject_code'  => $subject['subject_code'],
            'subject_marks'  => $subject_marks,
        ];
    }
// var_dump($subjects_results);
    $student_rt[$key1] = [
        'student_name'  => $student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name'],
        'gender'           => $student['gender'],
        'student_id'    => $student['student_id'],
        'candidate_no'  => $student['candidate_no'],
        'results'       => $subjects_results,
        'total_marks'   => $total_marks,
        'average_marks' => number_format((float)$avg_marks, 1, '.', ''),
        // 'avg_grade'     => $avg_grade,
        // 'avg_remark'    => $avg_remark,
        // 'average_marks' => $avg_marks,
        'pos'           => $key1,
        // 'examname'      => $examname,
        // 'examid'        => $examid,
        // 'total_students'=>\count($mid_term_student),
        // 'division'      => $divisions,
        'date'          => date('Y-m-d'),

    ];
}
?>

                                <form action="" method="POST">
                                <div id="print-content">
                                <div class="panel-body">
                            
                                <h5  style="text-align: center;"><b>THE UNITED REPUBLIC OF TANZANIA<br>PRESIDENT'S OFFICE-RALG<br>KILAKALA SECONDARY SCHOOL<br>P.O.BOX 40 MOROGORO<br><?php
                                include('include/config.php');
                                $school=openssl_decrypt ($_GET['view'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $search = "SELECT * FROM tbl_school_p WHERE school_no = '$school'";
                                $run_query = mysqli_query($con, $search);
                                while($row = mysqli_fetch_array($run_query)){
                                    $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                    ?>
                                        
                                            <?php echo $row['school_name'] ."  ".$row['school_district']."";?>
                                       
                                <?php } ?> 
                                <br>Email:<i>kilakalass1957@gmail.com,</i> Website:<i>www.kilakalasps.ac.tz </i></b><br>
                                <img src="img/bodi_logo.png" width="120px"><br>
                            </h5>
                                    <div class="table-responsive">
                                    <table border="2px" style="font-size: 70%">
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <thead style="font-size: 11.5px">
		<th class="table_title">SN</th>
		<th class="table_title">STUDENT NAME</th>
		<!--<th class="table_title">CAND #</th>
		<th class="table_title">GENDER</th>-->
		<?php foreach ($subjects as $key => $subject): ?>
        <th class="table_title"><?=$subject['subject_name'] ?></th>
		<?php endforeach ?>
		<!--<th>TOT</th>
		<th>AVG</th>
        <th>GRD</th>-->
        <th>PNT</th>
        <th>DIV</th>
        
	</thead>

                                            <tbody style="font-size: 11.5px">
		<?php foreach ($student_rt as $rekey => $value): ?>
			<tr>
				<td><?=$rekey+1 ?></td>
				<td><?=$value['student_name'] ?></td>
				<!--<td><?=$value['candidate_no'] ?></td>
				<td><?=$value['gender'] ?></td>-->
				<?php
                $marks = array();
                foreach ($value['results'] as $key => $res): ?>
				<td style="text-align: center;">
                <?php
                        // echo $res['subject_marks']." -"
                            $t = $res['subject_marks'];
                             array_push($marks,$t);
                             if($t>=75){
                                echo "'A'";
                             }else if($t>=65){
                                echo "'B'";
                             }else if($t>=45){
                                echo "'C'";
                             }else if($t>=30){
                                echo "'D'";
                             }else if($t>0){
                                echo "'F'";
                             }else if($t<0){
                                echo "";
                             }
                    ?> 
                </td>
				<?php endforeach ?>
				<!--<td><?php sort($marks);
                   $sm = 0;
                   $j = 0;
                   for($i = count($marks)-1 ; $i > 0 ; $i--){
                  
                    $sm = $sm + (int)$marks[$i];
                   
                    $j++;
                   }
                   $av = $sm/count($marks);
                   echo $sm;

                ?></td>
				<td><?php echo round($av,2);?></td>
               <td>
                <?php
$t = $value['average_marks'];

if ($t >= "75") {
  echo "A";
} else if ($t >= "65") {
    echo "B";
} else if ($t >= "45") {
    echo "C";
}else if ($t >= "30") {
    echo "D";
}else if ($t > "0") {
    echo "F";
}else if ($t < "0") {
    echo "";
}
?> 
</td>-->
<td>
                <?php sort($marks);
                   $sm = 0;
                   $j = 0;
                   $pnt = array();
                   for($i = count($marks)-1 ; $i > 0 ; $i--){
                   if($j == 7)break;
                    $sm = $sm + (int)$marks[$i];
                    if($marks[$i] >= 75){
                       array_push($pnt,1);
                    }
                    if($marks[$i] >=65 && $marks[$i] < 75){
                        array_push($pnt,2);
                     }
                     if($marks[$i] >= 45 && $marks[$i] < 65){
                        array_push($pnt,3);
                     }
                     if($marks[$i] >= 30 && $marks[$i] < 45){
                        array_push($pnt,4);
                     }
                     if($marks[$i] >= 0 && $marks[$i] < 30){
                        array_push($pnt,5);
                     }
                    
                    
                    
                    
                    $j++;
                   }
                   $total_pnt = 0;
                   for($k = 0 ; $k < count($pnt); $k++){
                     $total_pnt += (int)$pnt[$k];
                   }
                 echo $total_pnt;

               

echo "</td>";
echo "<td>";
if($total_pnt >= 7 && $total_pnt <18){
    echo "I";
}
if($total_pnt >= 18 && $total_pnt < 22){
    echo "II";
}
if($total_pnt >= 22 && $total_pnt <26){
    echo "III";
}
if($total_pnt >= 26 && $total_pnt < 29){
    echo "IV";
}
if($total_pnt >= 29 && $total_pnt < 36){
    echo "0";
}
echo "</td>";
?>
			</tr>
		<?php endforeach ?>
        
	</tbody>
   
                                        </table>
                                        <h5>Printed on:
                            <?php
                             date_default_timezone_set('Africa/Dar_es_Salaam');
                             echo " " . date('Y-m-d H:i:s');

                               ?></h5>
                                        <?php
	$con->close();
 ?>
                                    </div>
                                
                               
                            </div>
                       
                    </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
                            </div>
            <!-- /#page-wrapper -->

         <script type="text/javascript">
$('th:not(:first-child)').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){
        $(rows[i]).find('td:first').text(i + 1); //update the s.no td in each sorted row
        table.append(rows[i]);
    }
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

        </script>
         
        <?php include('include/footer.php') ?>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="js/main.js"></script>
