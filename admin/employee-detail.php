<?php

require 'database.php';
$pdo = Database::connect();
$user_detail_id = $_GET['id'];
$sql = "SELECT * FROM user_detail ud WHERE ud.user_detail_id = ?";
$q = $pdo -> prepare($sql);
$q -> execute(array($user_detail_id));
$userDetail = $q -> fetch(PDO::FETCH_ASSOC);

$register_id = $userDetail['register_id'];
$name = $userDetail['name'];
$gender = $userDetail['gender'];
$address = $userDetail['address'];
$phone = $userDetail['phone'];
$place_of_birth = $userDetail['place_of_birth'];
$date_of_birth = $userDetail['date_of_birth'];
$education = $userDetail['education'];
$univ = $userDetail['univ'];
$ipk = $userDetail['ipk'];
$noIjazah = $userDetail['no_ijazah'];
$activeFlag = $userDetail['active_flag'];
$email = $userDetail['email'];

Database::disconnect();
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
						Detail Data Calon Karyawan
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form">
								<div class="col-md-4">
									<h3><u>Informasi Pribadi</u></h3>

									<div class="form-group">
										<label>ID Pendaftar</span></label>
										: <?php echo $register_id; ?>
									</div>
									<div class="form-group">
										<label>Nama Lengkap</label>
										: <?php echo $name; ?>
									</div>
									<div class="form-group">
										<label>Jenis Kelamin</label>
										: <?php echo $gender=="Laki-Laki" ? 'Laki-Laki' : 'Perempuan' ?>
									</div>
									<div class="form-group">
										<label>Tempat Lahir</label>
										: <?php echo $place_of_birth; ?>
									</div>
									<div class="form-group">
										<label>Tanggal Lahir<span class="labelError"> <?php echo !empty($date_of_birthError) ? $date_of_birthError : ''; ?></span></label>
										: <?php echo $date_of_birth; ?>
									</div>
									<div class="form-group">
										<label>Alamat</label>
										: <?php echo $address; ?>
									</div>
									<div class="form-group">
										<label>Nomer Telp<span class="labelError"> <?php echo !empty($phoneError) ? $phoneError : ''; ?></span></label>
										: <?php echo $phone; ?>
									</div>
								</div>
								<div class="col-md-8">
									<h3><u>Informasi Akun</u></h3>
									<div class="form-group" >
										<label>Username</label>
										: <?php echo $register_id; ?>
									</div>
									<div class="form-group" >
										<label>Email</label>
										: <?php echo $email; ?>
									</div>
									<div class="form-group" >
										<label>Status</label>
									: <?php echo '<span class="label label-' . ($activeFlag==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span>' ?>
									</div>
									<h3><u>Informasi Pendidikan</u></h3>
									<div class="form-group">
										<label>Pendidikan</label>
										: <?php echo $education; ?>
									</div>
									<div class="form-group">
										<label>Universitas</label>
										: <?php echo $univ; ?>
									</div>
									<div class="form-group">
										<label>IPK</label>
										: <?php echo $ipk; ?>
									</div>
									<div class="form-group">
										<label>No Ijazah</label>
										: <?php echo $noIjazah; ?>
									</div>
								</div>
								<div class="col-md-12 text-right">
									<a class="btn btn-primary" href="home.php?menu=employee-edit&id=<?php echo $user_detail_id; ?>"><i class="fa fa-edit"></i>&nbsp;Edit</a>
									<?php if($activeFlag==1){ ?>
									<a class="btn btn-danger" href="home.php?menu=active-flag&id=<?php echo $user_detail_id; ?>&username=<?php echo $register_id; ?>&flag=0&type=userdetail"><i class="fa fa-lock"></i>&nbsp;Hapus</a>
									<?php }else{ ?>
									<a class="btn btn-success" href="home.php?menu=active-flag&id=<?php echo $user_detail_id; ?>&username=<?php echo $register_id; ?>&flag=1&type=userdetail"><i class="fa fa-unlock"></i>&nbsp;Aktifkan</a>
									<?php } ?>
									<a class="btn btn-warning" href="home.php?menu=employee-list"><i class="fa fa-reply"></i>&nbsp;Kembali</a>
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