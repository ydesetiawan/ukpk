<?php
include 'database.php';
$pdo = Database::connect();
$sql = "SELECT ud.* FROM answer a,user_detail ud, question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and ud.user_detail_id= a.user_detail_id GROUP BY a.user_detail_id";
$i = 1;
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-heading">
						Data Hasil Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Pendaftar</th>
										<th>Nama Lengkap</th>
										<th>Nilai Rata-Rata</th>
										<th>Minimum Nilai</th>
										<th>Keterangan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql) as $row) {

										$user_detail_id = $row['user_detail_id'];
										$sql_result_detail = "SELECT c.category_id as category_id,c.category_name as category_name,count(q.question_id) as question_total FROM question q,category c WHERE q.category_id = c.category_id GROUP BY c.category_id";

										$average = 0;
										$status = "";
										$minimum = $ini_minimum_value;
										$sumValue = 0;
										$sumTotal = 0;
										foreach ($pdo->query($sql_result_detail) as $row_result_detail) {
											$sql_question_answerd = "SELECT sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id=? and c.category_id=? GROUP BY q.category_id";
											$q = $pdo -> prepare($sql_question_answerd);
											$q -> execute(array($row['user_detail_id'], $row_result_detail['category_id']));
											$dataAnwered = $q -> fetch(PDO::FETCH_ASSOC);
											$totalValue = 0;
											if (!empty($dataAnwered)) {
												$totalValue = $dataAnwered['total_value'];
											}
											$sumValue = $sumValue + (($totalValue / $row_result_detail['question_total']) * 10);
											$sumTotal++;
										}

										$average = $sumValue / $sumTotal;

										if ($average >= $minimum) {
											$status = '<span class="label label-success">Lulus</span><span class="status-hidden">.lulus</span>';
										} else {
											$status = '<span class="label label-danger">Tidak Lulus</span><span class="status-hidden">.tidak</span>';
										}

										echo '<tr>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>' . $row['register_id'] . '</td>';
										echo '<td><a class="btn-link" href="home.php?menu=employee-detail&id=' . $row['user_detail_id'] . '"><i class="fa fa-bars"></i>&nbsp;' . $row['name'] . '</a></td>';
										echo '<td>' . round($average,1) . '</td>';
										echo '<td>' . $minimum . '</td>';
										echo '<td>' . $status . '</td>';
										echo '<td>';
										echo '&nbsp;';
										echo '<a class="btn btn-primary" href="home.php?menu=result-category-detail&id=' . $row['user_detail_id'] . '"><i class="fa fa-bars"></i>&nbsp;Detail</a>';
										echo '</td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class=" text-right">
					<a class="btn btn-success" id="onPrint"><i class="glyphicon glyphicon-print"></i>&nbsp;Cetak Hasil Uji Kompetensi</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="print-page">
	<div class="panel panel-primary">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<span class="labelError" style="font-size: 16px;">Sistem Aplikasi</span><br>
				<span style="font-size: 22px;font-weight: bold">Uji Kompetensi Penerimaan Karyawan</span><br>
                <span style="font-size: 16px;font-weight: bold">Alia Islamic School Tangerang</span>
				<h5>Data Hasil Uji Kompetensi</h5>
			</div>
			<div>
				<table class="table">
						<tr>
							<th>#</th>
							<th>ID Pendaftar</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Telp</th>
							<th>Nilai</th>
							<th>Keterangan</th>
						</tr>
						<?php
						$i=1;
						foreach ($pdo->query($sql) as $row) {

							$user_detail_id = $row['user_detail_id'];
							$sql_result_detail = "SELECT c.category_id as category_id,c.category_name as category_name,count(q.question_id) as question_total FROM question q,category c WHERE q.category_id = c.category_id GROUP BY c.category_id";

							$average = 0;
							$status = "";
							$minimum = $ini_minimum_value;
							$sumValue = 0;
							$sumTotal = 0;
							foreach ($pdo->query($sql_result_detail) as $row_result_detail) {
								$sql_question_answerd = "SELECT sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id=? and c.category_id=? GROUP BY q.category_id";
								$q = $pdo -> prepare($sql_question_answerd);
								$q -> execute(array($row['user_detail_id'], $row_result_detail['category_id']));
								$dataAnwered = $q -> fetch(PDO::FETCH_ASSOC);
								$totalValue = 0;
								if (!empty($dataAnwered)) {
									$totalValue = $dataAnwered['total_value'];
								}
								$sumValue = $sumValue + (($totalValue / $row_result_detail['question_total']) * 10);
								$sumTotal++;
							}

							$average = $sumValue / $sumTotal;

							if ($average >= $minimum) {
								$status = "<strong>LULUS</strong>";
							} else {
								$status = "<strong>TIDAK LULUS</strong>";
							}

							echo '<tr>';
							echo '<td>' . $i++ . '</td>';
							echo '<td>' . $row['register_id'] . '</td>';
							echo '<td>' . $row['name'] . '</td>';
							echo '<td>' . $row['email'] . '</td>';
							echo '<td>' . $row['phone'] . '</td>';
							echo '<td>' . round($average,1) . '</td>';
							echo '<td>' . $status . '</td>';
							echo '</tr>';
						}
						?>
				</table>
			</div>
		</div>
		<div class="text-center">
			Minimum nilai harus mencapai <b><?php echo $ini_minimum_value; ?></b>, sebagai syarat kelulusan uji kompetensi penerimaan karyawan <br>
			*) Tanggal cetak <?php echo date("d-m-Y"); ?> - Jam Cetak <?php echo date("G:i"); ?>
		</div>
		<br>
	</div>
</div>
