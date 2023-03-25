<?php
// memulai session
session_start();
error_reporting(0);
$role = null;
$user_id = "";
$user_name = "";

if (isset($_SESSION['role'])) {
	$role = $_SESSION['role'];
	$user_id = $_SESSION['user_id'];
	$user_name = $_SESSION['user_name'];
} else {
	header("Location:login.php");
	exit;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>UKPK </title>
		<!-- BOOTSTRAP STYLES-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<link href="assets/css/bootstrap-datepicker.css" rel="stylesheet" />
		<!-- JQUERY STYLES-->
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.countdown.css">
		<!-- FONTAWESOME STYLES-->
		<link href="assets/css/font-awesome.css" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="assets/css/custom.css" rel="stylesheet" />
		<!-- TABLE STYLES-->
		<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
		<style>
			.labelError {
				color: #C90000 !important
			}
		</style>
		<?php
		require 'conf.php';
		?>
	</head>
	<body>
		<div id="wrapper">
			<!-- /. NAV TOP  -->
			<?php
			$menu = null;
			if (!empty($_GET)) {
				$menu = $_GET['menu'];
			}
			if ($role == 'ADMIN') {
				//NAV SIDE
				include 'admin/navigation.php';
				//CONTENT
				if (empty($menu)) {
					include 'admin/dashboard.php';
				} else {
					//employee
					if ($menu == 'employee-add') {
						include 'admin/employee-add.php';
					} else if ($menu == 'employee-list') {
						include 'admin/employee-list.php';
					} else if (substr($menu, 0, 13) == 'employee-edit') {
						include 'admin/employee-edit.php';
					} else if (substr($menu, 0, 15) == 'employee-detail') {
						include 'admin/employee-detail.php';
						//category
					} else if ($menu == 'category-add') {
						include 'admin/category-add.php';
					} else if ($menu == 'category-list') {
						include 'admin/category-list.php';
					} else if (substr($menu, 0, 15) == 'category-detail') {
						include 'admin/category-detail.php';
					} else if ($menu == 'category-edit') {
						include 'admin/category-edit.php';
						//question
					} else if ($menu == 'question-add') {
						include 'admin/question-add.php';
					} else if ($menu == 'question-list') {
						include 'admin/question-list.php';
					} else if (substr($menu, 0, 15) == 'question-detail') {
						include 'admin/question-detail.php';
					} else if ($menu == 'question-edit') {
						include 'admin/question-edit.php';
						//result
					} else if ($menu == 'result-list') {
						include 'admin/result-list.php';
					} else if (substr($menu, 0, 26) == 'result-category-detail') {
						include 'admin/result-category-detail.php';
					} else if (substr($menu, 0, 23) == 'result-answer-detail') {
						include 'admin/result-answer-detail.php';
						//active-flag
					} else if (substr($menu, 0, 12) == 'active-flag') {
						include 'admin/active-flag.php';
					}else if ($menu == 'setting') {
						include 'admin/setting.php';
						//result
					}  else {
						include 'blank.php';
					}
				}
			} else if ($role == 'USER') {
				include 'user/navigation.php';

				//CONTENT
				if (empty($menu)) {
					include 'user/test-list.php';
				} else {
					//test
					if ($menu == 'test') {
						include 'user/test-list.php';
						//start test
					} else if ($menu == 'start-test') {
						include 'user/start-test.php';
						//start test
					} else if ($menu == 'finish-test') {
						include 'user/finish-test.php';
						//print
					} else if ($menu == 'print') {
						include 'user/print.php';
						//result
					} else {
						include 'blank.php';
					}
				}
			}
			?>
		</div>
		<!-- /. WRAPPER  -->
		<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
		<!-- JQUERY SCRIPTS -->
		<script src="assets/js/jquery-1.10.2.js"></script>
		<script src="assets/js/jquery.plugin.js"></script>
		<script src="assets/js/jquery.countdown.js"></script>
		<script src="assets/js/jquery.countdown-id.js"></script>
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.js"></script>
		<!-- METISMENU SCRIPTS -->
		<script src="assets/js/jquery.metisMenu.js"></script>
		<!-- DATA TABLE SCRIPTS -->
		<script src="assets/js/dataTables/jquery.dataTables.js"></script>
		<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
		<script src="assets/js/ukpk-custom.js"></script>
		<!-- CUSTOM SCRIPTS -->
		<script src="assets/js/custom.js"></script>
	</body>
</html>
