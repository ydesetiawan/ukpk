<?php
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT *  FROM user_detail ud,user u WHERE u.user_id = ud.user_id and u.role = "USER" ORDER BY user_detail_id DESC';
$count = $pdo -> query($sql) -> fetchColumn();
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
						Data Calon Karyawan
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>ID Pendaftar</th>
										<th>Nama Lengkap</th>
										<th>Email</th>
										<th>Tanggal Lahir</th>
										<th>No Telp</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql) as $row) {
										echo '<tr'.($row['active_flag']==1 ? "" : " style=color:red;" ). '>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>' . $row['register_id'] . '</td>';
										echo '<td>' . $row['name'] . '</td>';
										echo '<td>' . $row['email'] . '</td>';
										echo '<td>' . $row['date_of_birth'] . '</td>';
										echo '<td>' . $row['phone'] . '</td>';
										echo '<td><span class="label label-' . ($row['active_flag']==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span></td>';
										echo '<td>';
										echo '&nbsp;';
										echo '<a class="btn btn-primary" href="home.php?menu=employee-detail&id=' . $row['user_detail_id'] . '"><i class="fa fa-bars"></i>&nbsp;Detail</a>';
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
			</div>
		</div>
	</div>
</div>
