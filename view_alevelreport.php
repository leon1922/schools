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
$sql_subjects = "SELECT * FROM `tbl_primary_subject` WHERE  school_no='$school_no'";
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
            WHERE tbl_student_primary_subject.student_id='$sudentid'";
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

                            
                                <div id="print-content">
                                <div class="panel-body">
                            <table>
                                <tbody>
                                    <?php foreach ($student_rt as $rekey => $value): ?>
<tr>
  <td colspan="7">
    <table border="0">
      <tr>
        <td width="30px"><img src="nembo.png" width="100px" height="80px"></td>
        <td style="font-size: 14px" width="60px"><center> <header><b>OFISI YA RAISI-TAMISEMI<br>SHULE YA SEKONDARI KILAKALA<br>S.L.P 40 MOROGORO<br>TAARIFA YA MAENDELEO YA MWANAFUNZI<br>Email:<i>kilakalass1957@gmail.com,</i>&nbsp; &nbsp; Website:<i>www.kilakalasps.ac.tz </i></b></header>
        </center></td>
        <td width="30px"><img src="favicon.png" width="100px" height="80px"></td>
      </tr>
    </table>
  </td>
</tr>
  <tr>
   <td colspan="6">JINA LA MWANAFUNZI:<b><?=$value['student_name'] ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; </b></td>
   <td style="text-align: center;">JINSIA : KE </td>
  </tr>
   <tr>
   <td colspan="2">KIDATO: SITA </td>
   <td colspan="2" style="text-align: center;">PCB</td>
   <td colspan="2" style="text-align: center;">MWAKA : <?php echo date("Y"); ?>  </td>
   <td style="text-align: center;">MUHULA : I </td>
  </tr>
  <tr>
   <td colspan="7"><p  style="font-size: 14px"><b>A. TAARIFA YA MAENDELEO YA MASOMO NA TABIA YA MWANAFUNZI</b></p></td>
  </tr>
  <tr>
  <th width="2%">S/N</th>
  <th>SOMO</th>
  <th>ALAMA</th>
  <th>DARAJA</th>
  <th>CODE</th>
  <th>TABIA</th>
  <th>DARAJA LA TABIA</th>
  </tr>

  <tr>
  <td>1</td>
  <td>PHYSICS</td>
  <td></td>
  <td></td>
  <td>901</td>
  <td>Kufanya kazi kwa bidii</td>
  
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>2</td>
  <td>CHEMISTRY</td>
  <td></td>
  <td></td>
  <td>902</td>
  <td>Ubora na kiasi cha kazi</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>3</td>
  <td>BIOLOGY</td>
  <td></td>
  <td></td>
  <td>903</td>
  <td>Kupenda, kuheshimu na kuthamini kazi</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>4</td>
  <td>B.MATH</td>
  <td></td>
  <td></td>
  <td>904</td>
  <td>Uwelewano na ushirikiano</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>5</td>
  <td>G. STUDIES</td>
  <td></td>
  <td></td>
  <td>905</td>
  <td>Heshima kwa wenzake, viongozi na umma</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>6</td>
  <td>ISLAMIC</td>
  <td></td>
  <td></td>
  <td>906</td>
  <td>Uongozi na uwezo wa kujitolea</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td colspan="4" rowspan="5"></td>
  <td>907</td>
  <td>Moyo wa kujituma</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
 
  <td>908</td>
  <td>Usafi binafsi</td>
  <td style="text-align: center;"></td>
  </tr>
  
  <td>909</td>
  <td>Kushiriki katika michezo na utamaduni</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td>910</td>
  <td>Uangalifu na matumizi ya zana za kazi</td>
  <td style="text-align: center;"></td>
  </tr>
  <tr>
  <td colspan="3"><p align="center">A- Bora Sana,&nbsp; &nbsp;B-Vizuri Sana, &nbsp; &nbsp;C & D- Vizuri, &nbsp; &nbsp; E & S-Inaridhisha, &nbsp; &nbsp; F- Mbaya/Feli</p></td>
  </tr>
  <br>
  <tr>
   <td colspan="7"><p align="center">JUMLA YA ALAMA:<b>&nbsp; &nbsp;&nbsp; &nbsp;</b>WASTANI:<b>&nbsp; &nbsp;&nbsp; &nbsp;
   </b>DARAJA:<b> &nbsp; &nbsp;</b>NAFASI YAKE DARASANI:<b>&nbsp; &nbsp;&nbsp; &nbsp;</b>KATI YA:<b>&nbsp; &nbsp;
   &nbsp; &nbsp;</b>WA DARASA LAKE.</p></td>
  </tr>
  <tr>
   <td colspan="7">
   <table border="1px" width="100%" align="center">
    <tr>
     <td colspan="6" style="text-align: center;">Ufafanuzi wa alama na daraja kwa ujumla wake</td>
    </tr>
    <tr>
     <td>ASILIMIA</td>
     <td style="text-align: center;">75-100</td>
     <td style="text-align: center;">65-74</td>
     <td style="text-align: center;">45-64</td>
     <td style="text-align: center;">30-34</td>
     <td style="text-align: center;">0-29</td>
    </tr>
    <tr>
     <td rowspan="2">MAELEZO</td>
     <td style="text-align: center;">A</td>
     <td style="text-align: center;">B</td>
     <td style="text-align: center;">C</td>
     <td style="text-align: center;">D</td>
     <td style="text-align: center;">F</td>
    </tr>
     <tr>
     <td style="text-align: center;">Bora Sana</td>
     <td style="text-align: center;">Vizuri Sana</td>
     <td style="text-align: center;">Vizuri</td>
     <td style="text-align: center;">Inaridhisha</td>
     <td style="text-align: center;">Feli</td>
    </tr>
   </table>
   </td>
  </tr>
  <tr>
   <td colspan="7"><p  style="font-size: 14px"><b>B. KUFUNGA NA KUFUNGUA SHULE:</b></p></td>
 </tr>
<tr>
 <td colspan="7"><p>Shule imefungwa tarehe<b> 22/11/2019</b> na itafunguliwa <b>4/1/2020</b></p></td>
</tr>
<tr>
   <td colspan="7"><p style="font-size: 14px"><b>C. MAONI YA MWALIMU WA DARASA NA SAHIHI YA MWALIMU WA DARASA:</b></p></td>
 </tr>
<tr>
 <td colspan="7"><p></p></td>
</tr>
<tr>
   <td colspan="7"><p style="font-size: 14px"><b>D. MAONI YA MKUU WA SHULE:</b></p></td>
 </tr>
<tr>
 <td colspan="2"><p></p></td>
 <td colspan="2">Jina la mkuu wa shule:<br><b>Mildreda W. Selula</b> </td>
 <td><?php echo "Tarehe:<br>" . date("d/m/Y") . ""; ?></td>
 <td style="text-align: center;">Sahihi:<br><img src="sahihi.jpg" width="60px" height="20px"></td>
 <td  style="text-align: center;">Muhuri:<br><p style="font-size: 10px; font-family: ;color: blue;"><b>HEADMISTRESS <br>KILAKALA SECONDARY SCHOOL<br>P.O.BOX 40, MOROGORO</b></p></td>
</tr>
<br>
   <td colspan="7"><p align="center">........................X....................kata kipande hiki na kirudi shuleni..................X...................</p></td>
 </tr><br>
 <tr>
   <td colspan="7"><p style="font-size: 14px"><b>E. MAONI YA MZAZI/MLEZI:</b></p></td>
 </tr>
 <tr>
   <td colspan="7"><p>Mimi........................................ ambaye ni mzazi/mlezi wa Mwanafunzi.................................wa kidato cha....................nakiri kupokea fomu ya maendeleo ya mtoto wangu leo tarehe....../...../..........na nitahakikisha kuwa mwanangu atarudi siku ya kufungua ambayo ni tarehe <b>04/01/2020</b> na nitatoa ushirikiano kwa uongozi wa shule wa kumhamisha mwanangu ikiwa hatofikisha wastani wa shule ambao ni <b>60%</b> na haya ndio maoni yangu<br>...........................................................................................................................................................................................................................................<br>...........................................................................................................................................................................................................................................<br>...........................................................................................................................................................................................................................................<br><div align="center">Sahihi:...................................Tarehe:............................Namba ya simu:................................... </div></p></td>
 </tr>
</script>
  
   </div>

</div>
</div>
<?php endforeach ?>
</tbody>
                            </table>

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
