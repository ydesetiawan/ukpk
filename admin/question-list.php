<?php
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT *,q.active_flag as q_active_flag  FROM question q,category c Where q.category_id = c.category_id ORDER BY q.question_id DESC';
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
						Data Pertanyaan Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Kategori Uji Kompetensi</th>
										<th>Text Pertanyaan</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($pdo->query($sql) as $row) {
										echo '<tr'.($row['q_active_flag']==1 ? "" : " style=color:red;" ). '>';
										echo '<td>' . $i++ . '</td>';
										echo '<td>' . $row['category_name'] . '</td>';
										echo '<td>' . $row['question_text'] . '</td>';
										echo '<td><span class="label label-' . ($row['active_flag']==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span>';
										echo '<td>';
										echo '&nbsp;';
										echo '<a class="btn btn-primary" href="home.php?menu=question-detail&id=' . $row['question_id'] . '"><i class="fa fa-bars"></i>&nbsp;Detail</a>';
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
