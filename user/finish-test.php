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
}
require 'database.php';
$pdo = Database::connect();
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM user_detail WHERE user_detail_id = ?";
$q = $pdo -> prepare($sql);
$q -> execute(array($user_id));
$userdetail = $q -> fetch(PDO::FETCH_ASSOC);

if (!empty($_GET['id'])) {
	$category_id = $_GET['id'];

	$sql = "SELECT * FROM category WHERE category_id = ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($category_id));
	$category = $q -> fetch(PDO::FETCH_ASSOC);

}
Database::disconnect();
?>
<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<!-- Form Elements -->
				<div class="panel panel-primary">
					<div class="panel-body">
						<div class="text-center">
							<span class="labelError" style="font-size: 16px;">Sistem Aplikasi</span><br>
							<span style="font-size: 22px;font-weight: bold">Uji Kompetensi Penerimaan Karyawan</span>
							<h6>Tanggal <?php echo date("d-m-Y"); ?></h6>
						</div>
						<br>
						<table class="table">
							<tbody>
								<tr>
									<td> ID Pendaftar </td>
									<td> : <strong><?php echo $userdetail['register_id']; ?></strong></td>
								</tr>
								<tr>
									<td> Nama </td>
									<td> : <strong><?php echo $userdetail['name']; ?></strong></td>
								</tr>
								<tr>
									<td> Kategori Uji Kompetensi </td>
									<td> : <strong><?php echo $category['category_name']; ?></strong></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer text-center">
							Terimakasih anda telah mengikuti uji kompetensi penerimaan karyawan, anda dapat melanjutkan uji kompetensi berikutnya dengan klik tombol uji kompetensi kembali
					</div>
				</div>
				<div class=" text-right">
					<a href="home.php?menu=test" class="btn btn-warning"><i class="glyphicon glyphicon-backward"></i>&nbsp;Uji Kompetensi Kembali</a>
				</div>
			</div>
		</div>
	</div>
</div>
		