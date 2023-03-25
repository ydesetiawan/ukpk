<?php

include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT *  FROM category WHERE active_flag = 1';
$count_category = $pdo -> query($sql) -> rowCount();
$sql = 'SELECT *  FROM question WHERE active_flag = 1';
$count_question = $pdo -> query($sql) -> rowCount();
$sql_employee = "SELECT *  FROM user_detail ud,user u WHERE u.user_id = ud.user_id and ud.active_flag = 1 and u.role = 'USER'";
$count_employee = $pdo -> query($sql_employee) -> rowCount();
$sql_result = "SELECT ud.* FROM answer a,user_detail ud, question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and ud.user_detail_id= a.user_detail_id GROUP BY a.user_detail_id";
$count_result = $pdo -> query($sql_result) -> rowCount();
$i=1;
$n=1;
?>

<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Beranda Admin </h2>
				<h5>Selamat Datang <?php echo $user_name; ?>
				</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-6">
				<a href="home.php?menu=employee-list">
				<div class="panel panel-primary text-center no-boder bg-color-green">
					<div class="panel-body">
						<i class="fa fa-user fa-5x"></i>
						<h3><?php echo $count_employee; ?>
						Data</h3>
					</div>
					<div class="panel-footer back-footer-green">
						Data Calon Karyawan

					</div>
				</div> </a>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<a href="home.php?menu=category-list">
				<div class="panel panel-primary text-center no-boder bg-color-blue">
					<div class="panel-body">
						<i class="fa fa-edit fa-5x"></i>
						<h3><?php echo $count_category; ?>
						Data</h3>
					</div>
					<div class="panel-footer back-footer-blue">
						Data Kategori Uji Kompetensi

					</div>
				</div> </a>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<a href="home.php?menu=question-list">
				<div class="panel panel-primary text-center no-boder bg-color-brown">
					<div class="panel-body">
						<i class="fa fa-edit fa-5x"></i>
						<h3><?php echo $count_question; ?>
						Data</h3>
					</div>
					<div class="panel-footer back-footer-brown">
						Data Pertanyaan

					</div>
				</div> </a>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
				<a href="home.php?menu=result-list">
				<div class="panel panel-primary text-center no-boder bg-color-red">
					<div class="panel-body">
						<i class="fa fa-bar-chart-o fa-5x"></i>
						<h3><?php echo $count_result; ?>
						Hasil</h3>
					</div>
					<div class="panel-footer back-footer-red">
						Data Hasil Uji Kompetensi

					</div>
				</div> </a>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo "<strong>(".$count_employee.")</strong>"; ?> Data Calon Karyawan
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Pendaftar</th>
										<th>Nama Lengkap</th>
										<th>Email</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql_employee." limit 5") as $row) {
										echo '<tr>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>' . $row['register_id'] . '</td>';
										echo '<td>' . $row['name'] . '</td>';
										echo '<td>' . $row['email'] . '</td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
							<div class="text-right"><a href="home.php?menu=employee-list">Lihat semua data pendaftaran karyawan</a></div>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo "<strong>(".$count_result.")</strong>"; ?> Hasil Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Pendaftar</th>
										<th>Nama Lengkap</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql_result." limit 5") as $row) {
										
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
										echo '<td>' . $n++ .'</td>';
										echo '<td>' . $row['register_id']. '</td>';
										echo '<td>' . $row['name']. '</td>';
										echo '<td>' . $status. '</td>';
										echo '</tr>';
									}
									Database::disconnect();
									?>
								</tbody>
							</table>
							<div class="text-right"><a href="home.php?menu=result-list">Lihat semua hasil uji kompetesi</a></div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>

	<!-- /. ROW  -->
</div>
</div>

