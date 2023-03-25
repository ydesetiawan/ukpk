<?php
include 'database.php';
$pdo = Database::connect();
$user_detail_id = $_GET['id'];
//$sql = "SELECT c.category_id as category_id,c.category_name as category_name,count(a.question_id) as question_total,sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id = '$user_detail_id' GROUP BY q.category_id";
$sql_category = "SELECT c.category_id as category_id,c.category_name as category_name,count(q.question_id) as question_total FROM question q,category c WHERE q.category_id = c.category_id GROUP BY c.category_id";

$i = 1;

$sql_user_detail = "SELECT * FROM user_detail ud WHERE ud.user_detail_id = ?";
$q = $pdo -> prepare($sql_user_detail);
$q -> execute(array($user_detail_id));
$userDetail = $q -> fetch(PDO::FETCH_ASSOC);
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
						Detail Data Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label>ID Pendaftar : </label><?php echo $userDetail['register_id']; ?>
							<br>
							<label>Nama Calon Karyawan : </label><?php echo $userDetail['name']; ?>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Kategori Uji Kompetensi</th>
										<th>Total Soal</th>
										<th>Jawaban Benar</th>
										<th class="text-right">Nilai</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$average = 0;
									$status = "";
									$minimum = $ini_minimum_value;
									$sumValue = 0;
									foreach ($pdo->query($sql_category) as $row) {
										$sql_question_answerd = "SELECT sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id=? and c.category_id=? GROUP BY q.category_id";
										$q = $pdo -> prepare($sql_question_answerd);
										$q -> execute(array($user_detail_id, $row['category_id']));
										$dataAnwered = $q -> fetch(PDO::FETCH_ASSOC);
										$totalValue=0;
										if(!empty($dataAnwered)){
											$totalValue = $dataAnwered['total_value'];
										}
										echo '<tr>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>';
										echo '&nbsp';
										echo '<a class="btn-link" href="home.php?menu=result-answer-detail&id=' . $row['category_id'] . '&userid=' . $user_detail_id . '"><i class="fa fa-bars"></i>&nbsp;' . $row['category_name'] . '</a>';
										echo '</td>';
										echo '<td>' . $row['question_total'] . '</td>';
										echo '<td>' . $totalValue / 10 . '</td>';
										echo '<td class="text-right">' . ($totalValue / $row['question_total']) * 10 . '</td>';
										echo '</tr>';

										$sumValue = $sumValue + (($totalValue / $row['question_total']) * 10);
									}
									Database::disconnect();
									?>
									<tr>
										<td>#</td>
										<td class="text-right" colspan="3">Nilai Rata-Rata</td>
										<td class="text-right" colspan="2"><?php $average = $sumValue / ($i - 1); echo round($average,1); ?></td>
									</tr>
									<tr>
										<td>#</td>
										<td class="text-right" colspan="3">Minimum NIlai</td>
										<td class="text-right" colspan="2"><?php echo $minimum; ?></td>
									</tr>
									<tr>
										<td>#</td>
										<td class="text-right" colspan="3">Keterangan</td>
										<td class="text-right" colspan="2"> <?php echo '<span class="label label-' . ($average >= $minimum ? 'success"> Lulus' : 'danger"> Tidak Lulus' ). '</span>' ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-12 text-right">
							<a class="btn btn-warning" href="home.php?menu=result-list"><i class="fa fa-reply"></i>&nbsp;Kembali</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
