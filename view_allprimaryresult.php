<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/main.css">
<script src="js/vendor/modernizr-2.6.2.min.js"></script>
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
                            <h5 class="page-header" style="text-align: center;">VIEW RESULTS OF ALL STUDENTS
                            
                            </h5>
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

$sql_students = "SELECT * FROM `tbl_student` JOIN tbl_school_p WHERE tbl_student.school_no = tbl_school_p.school_no ORDER BY first_name, middle_name, last_name";
$sql_subjects = "SELECT * FROM `tbl_primary_subject`";
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
            -- INNER JOIN tbl_student_primary ON tbl_student_primary.student_id = tbl_student_primary_subject.student_id
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
        'school_name'  => $student['school_name'],
        'school_district'  => $student['school_district'],
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
                                <div class="panel-body">
                                    <div class="table-responsive">
       <table class="table table-striped  table-bordered table-hover" id="dataTables-example" >

       <thead style="font-size: 11px">
		<th class="table_title">SN</th>
		<th class="table_title">STUDENT</th>
		<!--<th class="table_title">CAND #</th>-->
        <th class="table_title">EXAM</th>
        <th class="table_title">CLASS</th>
		<!--<th class="table_title">GENDER</th>-->
		<?php foreach ($subjects as $key => $subject): ?>
        <th class="table_title"><?=$subject['subject_name'] ?></th>
		<?php endforeach ?>
		<th>TOT</th>
		<th>AVG</th>
	</thead>

                                            <tbody style="font-size: 10.5px">
		<?php foreach ($student_rt as $rekey => $value): ?>
			<tr>
				<td><?=$rekey+1 ?></td>
				<td><?=$value['student_name'] ?></td>
				<!--<td><?=$value['candidate_no'] ?></td>-->
                <td><?=$value['school_name'] ?></td>
                <td><?=$value['school_district'] ?></td>
				<!--<td style="text-align: center;"><?=$value['gender'] ?></td>-->
				<?php foreach ($value['results'] as $key => $res): ?>
				<td style="text-align: center;"><?=$res['subject_marks'] ?></td>
				<?php endforeach ?>
				<td style="text-align: center;"><?=$value['total_marks'] ?></td>
				<td style="text-align: center;"><?=$value['average_marks'] ?></td>

			</tr>
		<?php endforeach ?>
	</tbody>
                                        </table>
                                        <?php
	$con->close();
 ?>
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
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="js/main.js"></script>

</html>
