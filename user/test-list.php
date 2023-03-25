<?php
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT *  FROM category c WHERE c.category_id IN (SELECT q.category_id FROM question q WHERE q.category_id = c.category_id) AND c.active_flag=1 ORDER BY c.category_id DESC';
$i = 1;

$sql_answered = "SELECT * FROM answer where user_detail_id = $user_id";
$countAnswered = $pdo -> query($sql_answered) -> rowCount();
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-offset-4 col-md-3">
				<div id="changeSession"></div>
				<div id="beforeTimeTest" style="padding: 10px;"></div>
				<div id="startTimeTest" style="background: #428bca;color: white;  padding: 10px;"></div>
				<div id="finishTest" class="is-countdown" style="background: rgb(32, 184, 74);color: white; padding: 10px;"><center><b>Uji Kompetensi Telah Berakhir</b></center></div>
			</div>
			<div class="col-md-12">
				<h2>Uji Kompetensi</h2>
				<h5>Selamat datang <strong><?php echo $user_name; ?></strong>, silahkan mengikuti uji kompetensi penerimaan karyawan. </h5>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<!-- Advanced Tables -->
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Uji Kompetensi</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql) as $row) {
										$category_id = $row['category_id'];
										$sql = "SELECT a.flag as flag FROM answer a,question q,category c WHERE q.category_id = ? AND q.question_id = a.question_id AND a.user_detail_id = ? group by a.answer_id";
										$q = $pdo -> prepare($sql);
										$q -> execute(array($category_id, $user_id));
										$flagAnswer = $q -> fetch(PDO::FETCH_ASSOC);

										if ($allowedTest == 0) {
											$status = '<span class="label label-warning">Belum Ujian</span>';
										} else if ($allowedTest == 1) {
											$status = '<span class="label label-primary">Mulai Ujian</span>';
										} else if ($allowedTest == 2) {
											$status = '<span class="label label-success">Selesai Ujian</span>';
										}

										echo '<tr>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>' . $row['category_name'] . '</td>';
										echo '<td>' . $status . '</td>';
										echo '<td>';
										if ($flagAnswer['flag'] == 1) {
											echo '<span style="color:rgb(32, 184, 74)"><i class="fa fa-check"></i>&nbsp;Sudah Uji Kompetensi</span>';
										} else if ($flagAnswer['flag'] == 0 && $allowedTest == 1) {
											echo '<a class="btn-link btn-primary ukpkStartTest" href="home.php?menu=start-test&id=' . $row['category_id'] . '"><i class="fa fa-play"></i>&nbsp;Mulai Uji Kompetensi&nbsp;&nbsp;&nbsp;</a>';
										}
										if ($flagAnswer['flag'] == 0 && $allowedTest == 2) {
											echo '<span style="color:#C90000 "><i class="fa fa-times"></i>&nbsp;Waktu sudah habis</span>';
										}
										if ($flagAnswer['flag'] == 0 && $allowedTest == 0) {
											echo '<span class="ukpkBeforeTest"><i class="fa fa-minus"></i>&nbsp;Belum Uji Kompetensi</span>';
										}
										echo '</td>';
										echo '</tr>';
									}
									Database::disconnect();
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php if($countAnswered>0){?>
				<div class=" text-right">
					<a href="home.php?menu=print" class="btn btn-success"><i class="glyphicon glyphicon-book"></i>&nbsp;Lihat Bukti Uji Kompetensi</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
