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
                            <h4 class="page-header">View results - 
                            <?php
                                include('include/config.php');
                                $school=openssl_decrypt ($_GET['view'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $search = "SELECT * FROM tbl_school WHERE school_no = '$school'";
                                $run_query = mysqli_query($con, $search);
                                while($row = mysqli_fetch_array($run_query)){
                                    $school_no=openssl_encrypt ($row['school_no'], $ciphering, $decryption_key, $options, $decryption_iv);
                                    ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['school_no'] .", ". $row['school_name'] ." (".$row['school_district'].")";?></td>
                                        </tr>
                                <?php } ?>
                            </h4>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                <?php
                                     include('include/config.php');
                                     $subject_code=openssl_decrypt ($_GET['subject_code'], $ciphering, $decryption_key, $options, $decryption_iv);
                                     $find = "SELECT DISTINCT subject_name FROM tbl_subject WHERE subject_code = '$subject_code'";
                                     $go = mysqli_query($con, $find);
                                     while($row11 = mysqli_fetch_array($go)){
                                        echo $row11['subject_name'];
                                     }
                                  ?>
                                </div> -->
                                <!-- /.panel-heading -->
                                <?php
                                $school_no=openssl_decrypt ($_GET['view'], $ciphering, $decryption_key, $options, $decryption_iv);
                                $student_rt = [];

$sql_students = "SELECT * FROM `tbl_student` WHERE school_no='$school_no'";
$sql_subjects = "SELECT * FROM `tbl_subject`";
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

        $tbl_student_subject_query = "SELECT * FROM tbl_student_subject
            -- INNER JOIN tbl_student ON tbl_student.student_id = tbl_student_subject.student_id
            INNER JOIN tbl_subject ON tbl_subject.subject_id = tbl_student_subject.subject_id
            WHERE tbl_student_subject.student_id='$sudentid' ";
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
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                            
                                            <thead>
		<th class="table_title">sn</th>
		<th class="table_title">student</th>
		<th class="table_title">candidate #</th>
		<th class="table_title">gender</th>
		<?php foreach ($subjects as $key => $subject): ?>
        <th class="table_title"><?=$subject['subject_name'] ?></th>
		<?php endforeach ?>
		<th>marks</th>
		<th>Avg</th>
		<th>Pos</th>
	</thead>

                                            <tbody>
		<?php foreach ($student_rt as $rekey => $value): ?>
			<tr>
				<td><?=$rekey+1 ?></td>
				<td><?=$value['student_name'] ?></td>
				<td><?=$value['candidate_no'] ?></td>
				<td><?=$value['gender'] ?></td>
				<?php foreach ($value['results'] as $key => $res): ?>
				<td><?=$res['subject_marks'] ?></td>
				<?php endforeach ?>
				<td><?=$value['total_marks'] ?></td>
				<td><?=$value['average_marks'] ?></td>
				<td><?=$value['pos']+1 ?></td>
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
