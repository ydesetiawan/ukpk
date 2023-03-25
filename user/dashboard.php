<?php
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT *  FROM category c WHERE c.category_id IN (SELECT q.category_id FROM question q WHERE q.category_id = c.category_id) ORDER BY category_id DESC';
$count = $pdo -> query($sql) -> rowCount();
$i = 1;
$countNot = 0;
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Beranda User</h2>
				<h5>Selamat Datang <?php echo $user_name; ?></h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			
			<div class="col-md-9 col-sm-12 col-xs-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						 Uji Kompetensi (Sudah Selesai)
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Uji Kompetensi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql) as $row) {
										$category_id = $row['category_id'];
										$sql = "SELECT a.* FROM answer a,question q,category c WHERE q.category_id = $category_id AND q.question_id = a.question_id AND a.user_detail_id = $user_id group by a.answer_id";
										$count = $pdo -> query($sql) -> rowCount();
										$status = "Belum melakukan uji kompetensi";
										if ($count > 0) {
											$status = "Sudah selesai melakukan uji kompetensi";

											echo '<tr>';
											echo '<td>' . $i++ . '</td>';
											echo '<td>' . $row['category_name'] . '</td>';
											echo '<td>';
											echo '<a class="btn btn-success" href="home.php?menu=print&id=' . $row['category_id'] . '"><i class="fa fa-check"></i>&nbsp;Sudah Uji Kompetensi</a>';
											echo '</td>';
											echo '</tr>';
										}else{
											$countNot++;
										}
										
									}
									if($countNot==0){
										echo '<tr><td colspan="3">Anda Belum melakukan uji kompetensi</td> </tr>';
									}
									Database::disconnect();
									?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div class="panel panel-primary text-center no-boder bg-color-green">
                    <div class="panel-body">
                        <i class="fa fa-edit fa-5x"></i>
                        <h4><?php echo "<strong>(" . $countNot. ")</strong>"; ?> Uji kompetensi yang belum diikuti. </h4>
                         <h5><a href="home.php?menu=test" style="color: white">Tampilkan uji kompetensi</a>  </h5>
                    </div>
                </div>
            </div>

		</div>

		<!-- /. ROW  -->
	</div>
</div>

