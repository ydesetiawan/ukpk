<?php
session_start();
if (!empty($_SESSION['role'])) {
	header("Location:home.php");
	exit;
}

require 'database.php';

if (!empty($_POST)) {

	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$loginError = null;
	// query untuk mendapatkan record dari username
	$pdo = Database::connect();
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM user WHERE username = ? and password = ? and active_flag = 1";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($username, $password));
	$data = $q -> fetch(PDO::FETCH_ASSOC);

	if (!empty($data)) {
		$username = $data['username'];
		$_SESSION['role'] = $data['role'];

		$sql = "SELECT ud.user_detail_id as id,ud.name as name,u.username as username FROM user u,user_detail ud WHERE u.username = ? and u.user_id =ud.user_id";
		$q = $pdo -> prepare($sql);
		$q -> execute(array($username));
		$userDetail = $q -> fetch(PDO::FETCH_ASSOC);
		$_SESSION['user_id'] = $userDetail['id'];
		$_SESSION['user_name'] = $userDetail['name'];

		header('location: home.php');
	} else {
		$loginError = "Username dan password salah!";
	}
	Database::disconnect();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>SkillMatch</title>
		<!-- BOOTSTRAP STYLES-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FONTAWESOME STYLES-->
		<link href="assets/css/font-awesome.css" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="assets/css/custom.css" rel="stylesheet" />
		<style>
			.labelError {
				color: #C90000 !important
			}

		</style>
	</head>
	<body>
  		<div id="page-inner" >


			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<!-- Form Elements -->
					<div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <div class="card-header text-center">
                                    <img src="assets/img/skill-match-logo.png" width="300px"/>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="panel-body">
                            <h3>Welcome to skillmatch </h3>
                            Please login to your account and start the adventure
                        </div>
						<div class="panel-body">

							<div class="row">
								<div class="col-md-12">
									<form action="login.php" method="post">
										<span class="labelError"><?php echo !empty($loginError) ? $loginError : ''; ?></span>
										<div class="form-group">
											<label>Username</label>
											<input class="form-control" name="username"/>
										</div>
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" name="password" />
										</div>
										<button type="submit" class="btn btn-primary col-lg-12">
											Login
										</button>


									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- JQUERY SCRIPTS -->
		<script src="assets/js/jquery-1.10.2.js"></script>
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="assets/js/bootstrap.min.js"></script>

	</body>
</html>
