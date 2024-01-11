<?php

require 'database.php';
$pdo = Database::connect();
$sql_user = 'SELECT * FROM user WHERE role = "USER"';
$count_user = $pdo -> query($sql_user) -> rowCount();
$code = "USR";
$generator = "";
$count_user = $count_user + 1;
if ($count_user >= 1000) {
	$generator = "" . $count_user;
} else if ($count_user >= 100) {
	$generator = "0" . $count_user;
} else if ($count_user >= 10) {
	$generator = "00" . $count_user;
} else if ($count_user >= 1) {
	$generator = "000" . $count_user;
}
$code = $code . $generator;
Database::disconnect();

if (!empty($_POST)) {



	$register_idError = null;
	$nameError = null;
	$genderError = null;
	$addressError = null;
	$phoneError = null;
	$place_of_birthError = null;
	$date_of_birthError = null;
	$educationError = null;
	$univError = null;
	$ipkError = null;
	$noIjazahError = null;
	$usernameError = null;
	$passwordError = null;
	$user = null;
	$emailError = null;

	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$register_id = $_POST['register_id'];
	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$place_of_birth = $_POST['place_of_birth'];
	$date_of_birth = $_POST['date_of_birth'];
	$education = $_POST['education'];
	$univ = $_POST['univ'];
	$ipk = $_POST['ipk'];
	$noIjazah = $_POST['noIjazah'];

	$valid = true;

	if (empty($username)) {
		$usernameError = 'Dimohon untuk memasukkan Username!';
		$valid = false;
	}
	if (empty($password)) {
		$passwordError = 'Dimohon untuk memasukkan Password yang sama dengan Tanggal Lahir!';
		$valid = false;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailError = 'Dimohon untuk memasukkan Email dengan benar!';
		$valid = false;
	}

	if (empty($register_id)) {
		$register_idError = 'Dimohon untuk memasukkan ID Register!';
		$valid = false;
	}
	if (empty($name)) {
		$nameError = 'Dimohon untuk memasukkan Nama Lengkap!';
		$valid = false;
	}
	if (empty($gender)) {
		$genderError = 'Dimohon untuk memasukkan Jenis Kelamin!';
		$valid = false;
	}
	if (empty($date_of_birth)) {
		$date_of_birthError = 'Dimohon untuk memasukkan Tanggal Lahir!';
		$valid = false;
	}
	if (empty($phone)) {
		$phoneError = 'Dimohon untuk memasukkan Telepon!';
		$valid = false;
	}
	if (empty($noIjazah)) {
		$noIjazahError = 'Dimohon untuk memasukkan No Ijazah!';
		$valid = false;
	}

	$pdo = Database::connect();
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM user WHERE username = ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($username));

	$user = $q -> fetch(PDO::FETCH_ASSOC);

	if (!empty($user)) {
		$usernameError = "Username " . $user['username'] . " sudah ada!";
		$valid = false;
	}

	if ($valid) {

		$password = md5($password);
		//insert user
		$sql = "INSERT INTO user (username,password,role,active_flag) values(?,?,?,?)";
		$q = $pdo -> prepare($sql);
		$q -> execute(array($username, $password, 'USER', TRUE));


        try {

            // select user
            $sql = "SELECT * FROM user WHERE username = ? ";
            $q = $pdo -> prepare($sql);
            $q -> execute(array($username));
            $user = $q -> fetch(PDO::FETCH_ASSOC);
            // insert user detail
            $sql = "INSERT INTO user_detail (register_id, name,email, gender, address, phone, place_of_birth, date_of_birth, education, univ, ipk, no_ijazah, user_id,active_flag) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            echo $sql;
            $q = $pdo -> prepare($sql);
            $q -> execute(array($register_id, $name,$email, $gender, $address, $phone, $place_of_birth, $date_of_birth, $education, $univ, $ipk, $noIjazah, $user['user_id'], TRUE));

            echo "<script>window.location.href='home.php?menu=employee-list';</script>";
            exit;
        } catch (Exception $e) {
            // Catch the exception and log a message
            $errorMessage = "Error: " . $e->getMessage();
            error_log($errorMessage);
            echo $errorMessage;

        }

	}
	Database::disconnect();
}
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- Form Elements -->
				<div class="panel panel-default">
					<div class="panel-heading">
						Pendaftaran Calon Karyawan
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form" action="home.php?menu=employee-add" method="post">
								<div class="col-md-6">
									<h3>Informasi Pribadi</h3>

									<div class="form-group <?php echo !empty($register_idError) ? 'has-error' : ''; ?>">
										<label>ID Pendaftar*<span class="labelError"> <?php echo !empty($register_idError) ? $register_idError : ''; ?></span></label>
										<input class="form-control" name="register_id" readonly="readonly" value="<?php echo $code; ?>"/>
									</div>
									<div class="form-group <?php echo !empty($nameError) ? 'has-error' : ''; ?>">
										<label>Nama Lengkap*<span class="labelError"> <?php echo !empty($nameError) ? $nameError : ''; ?></span></label>
										<input class="form-control" name="name" value="<?php echo $name; ?>"/>
									</div>
									<div class="form-group <?php echo !empty($genderError) ? 'has-error' : ''; ?>">
										<label>Jenis Kelamin*<span class="labelError"> <?php echo !empty($genderError) ? $genderError : ''; ?></span></label>
										<div class="radio">
											<label>
												<input type="radio" name="gender" value="Laki-Laki" <?php echo $gender=="Laki-Laki" ? 'checked' : '' ?>/>
												Laki - Laki </label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" name="gender" value="Perempuan" <?php echo $gender=="Perempuan" ? 'checked' : '' ?>/>
												Perempuan </label>
										</div>
									</div>
									<div class="form-group">
										<label>Tempat Lahir</label>
										<input class="form-control" name="place_of_birth" value="<?php echo $place_of_birth; ?>"/>
									</div>
									<div class="form-group">
										<label>Tanggal Lahir*<span class="labelError"> <?php echo !empty($date_of_birthError) ? $date_of_birthError : ''; ?></span></label>
										<div class="form-group input-group">
										    <input class="form-control datepicker" id="employee_date_of_birth" readonly="readonly" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
										    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>
									</div>
									<div class="form-group">
										<label>Alamat</label>
										<textarea class="form-control" rows="3" name="address"><?php echo $address; ?></textarea>
									</div>
									<div class="form-group <?php echo !empty($phoneError) ? 'has-error' : ''; ?>">
										<label>Nomer Telp*<span class="labelError"> <?php echo !empty($phoneError) ? $phoneError : ''; ?></span></label>
										<input class="form-control" name="phone" value="<?php echo $phone; ?>"/>
									</div>
								</div>
								<div class="col-md-6">
									<h3>Informasi Akun</h3>
									<div class="form-group <?php echo !empty($usernameError) ? 'has-error' : ''; ?>" >
										<label>Username*<span class="labelError"> <?php echo !empty($usernameError) ? $usernameError : ''; ?></span></label>
										<input class="form-control" name="username" readonly="readonly" value="<?php echo $code; ?>"/>
									</div>
									<div class="form-group <?php echo !empty($passwordError) ? 'has-error' : ''; ?>">
										<label>Password*<span class="labelError"> <?php echo !empty($passwordError) ? $passwordError : ''; ?></span></label>
										<input type="password" class="form-control" name="password"/>
									</div>
									<div class="form-group <?php echo !empty($emailError) ? 'has-error' : ''; ?>" >
										<label>Email*<span class="labelError"> <?php echo !empty($emailError) ? $emailError : ''; ?></span></label>
										<input class="form-control" name="email" value="<?php echo $email; ?>"/>
									</div>
									<h3>Informasi Pendidikan</h3>
									<div class="form-group">
										<label>Pendidikan</label>
										<input class="form-control" name="education" value="<?php echo $education; ?>"/>
									</div>
									<div class="form-group">
										<label>Universitas</label>
										<input class="form-control" name="univ" value="<?php echo $univ; ?>"/>
									</div>
									<div class="form-group">
										<label>IPK</label>
										<input class="form-control" name="ipk" value="<?php echo $ipk; ?>"/>
									</div>
									<div class="form-group <?php echo !empty($noIjazahError) ? 'has-error' : ''; ?>">
										<label>No Ijazah*<span class="labelError"> <?php echo !empty($noIjazahError) ? $noIjazahError : ''; ?></span></label>
										<input class="form-control" name="noIjazah" value="<?php echo $noIjazah; ?>"/>
									</div>
								</div>
								<div class="col-md-12 text-right">
									<button type="submit" class="btn btn-primary">
										Simpan
									</button>
									<button type="reset" class="btn btn-default">
										Ulang
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
		</div>
	</div>
</div>