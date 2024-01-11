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

//$sql = "SELECT c.category_id as category_id,c.category_name as category_name,count(a.question_id) as question_total,sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id = '$user_id' GROUP BY q.category_id";
$sql = 'SELECT *  FROM category c WHERE c.category_id IN (SELECT q.category_id FROM question q WHERE q.category_id = c.category_id) AND c.active_flag=1 ORDER BY c.category_id DESC';

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
									<td> : </td>
									<td><strong><?php echo $userdetail['register_id']; ?></strong></td>
								</tr>
								<tr>
									<td> Nama </td>
									<td> : </td>
									<td><strong><?php echo $userdetail['name']; ?></strong></td>
								</tr>
								<tr>
									<td> Kategori Uji Kompetensi </td>
									<td> : </td>
									<td>
										<strong>
											<?php
											$i = 0;
											foreach ($pdo->query($sql) as $row) {
												echo($i == 0 ? "" : ", ");
												echo $row['category_name'];
												$i++;
											}
											?>
										</strong>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer text-center">
							Terimakasih anda telah mengikuti uji kompetensi penerimaan karyawan, anda dapat melakukan uji kompetensi sebanyak 1 Kali, bukti uji kompetensi dapat Anda cetak melaui link cetak bukti uji kompetensi dibawah
					</div>
				</div>
				<div class=" text-right">
					<a class="btn btn-success" id="onPrint"><i class="glyphicon glyphicon-print"></i>&nbsp;Cetak Bukti Uji Kompetensi</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="print-page">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="text-center">
				<span class="labelError" style="font-size: 16px;">Sistem Aplikasi</span><br>
				<span style="font-size: 22px;font-weight: bold">Uji Kompetensi Penerimaan Karyawan</span>
				<h6>Terimakasih anda telah mengikuti uji kompetensi penerimaan karyawan</h6>
			</div>
			<br>
			<table class="table">
				<tbody>
					<tr>
						<td> ID Pendaftar </td>
						<td> : </td>
						<td><strong><?php echo $userdetail['register_id']; ?></strong></td>
					</tr>
					<tr>
						<td> Nama </td>
						<td> : </td>
						<td><strong><?php echo $userdetail['name']; ?></strong></td>
					</tr>
					<tr>
						<td> Tanggal </td>
						<td> : </td>
						<td><strong><?php echo date("d-m-Y"); ?></strong></td>
					</tr>
					
					<tr>
						<td> Kategori Uji Kompetensi </td>
						<td> : </td>
						<td><strong>
							<?php
							$i = 0;
							foreach ($pdo->query($sql) as $row) {
								echo($i == 0 ? "" : ", ");
								echo $row['category_name'];
								$i++;
							}
							?>
						</strong></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="panel-footer text-center">
			Simpan sebagai bukti bahwa anda telah mengikuti uji kompetensi penerimaan karyawan
			<br>
			*) Tanggal cetak <?php echo date("d-m-Y"); ?> - Jam Cetak <?php echo date("G:i"); ?> 
		</div>
	</div>
</div>


		