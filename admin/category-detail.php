<?php

require 'database.php';
$pdo = Database::connect();
$category_id = $_GET['id'];
$sql = "SELECT * FROM category c WHERE c.category_id = ?";
$q = $pdo -> prepare($sql);
$q -> execute(array($category_id));
$categoryDetail = $q -> fetch(PDO::FETCH_ASSOC);

$category_name = $categoryDetail['category_name'];
$description = $categoryDetail['description'];
$activeFlag = $categoryDetail['active_flag'];

$sql_question = "SELECT *,q.active_flag as q_active_flag FROM question q,category c WHERE q.category_id = c.category_id AND q.category_id = :category_id ";

Database::disconnect();
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" >
					<div class="panel-heading">
						Detail Data Kategori Uji Kompetensi
					</div>
					<div class="panel-body" >
						<div class="row" >
							<form role="form">
								<div class="col-md-12">
									<div class="form-group" >
										<label>Nama Kategori</span></label>
										: <?php echo $category_name; ?>
									</div>
									<div class="form-group">
										<label>Keterangan</label>
										: <?php echo $description; ?>
									</div>
									<div class="form-group">
										<label>Status</label>
										: <?php echo '<span class="label label-' . ($activeFlag==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span>' ?>
									</div>
								</div>
								<div class="col-md-12 text-right">
									<a class="btn btn-primary" href="home.php?menu=category-edit&id=<?php echo $category_id; ?>"><i class="fa fa-edit"></i>&nbsp;Edit</a>
									<?php if($activeFlag==1){
									?>
									<a class="btn btn-danger" href="home.php?menu=active-flag&id=<?php echo $category_id; ?>&flag=0&type=category"><i class="fa fa-lock"></i>&nbsp;Hapus</a>
									<?php }else{ ?>
									<a class="btn btn-success" href="home.php?menu=active-flag&id=<?php echo $category_id; ?>&flag=1&type=category"><i class="fa fa-unlock"></i>&nbsp;Aktifkan</a>
									<?php } ?>
									<a class="btn btn-warning" href="home.php?menu=category-list"><i class="fa fa-reply"></i>&nbsp;Kembali</a>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="panel panel-default" >
					<div class="panel-heading">
						Data Pertanyaan Uji Kompetensi
					</div>
					<div class="panel-body" >
						<?php
						$i = 1;
                        $stmt = $pdo->prepare($sql_question);
                        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

                        // Execute the query
                        $stmt->execute();
                        foreach ($stmt as $row) {
							$question_id = $row['question_id'];
							$questionText = $row['question_text'];
							$answerA = $row['answer_a'];
							$answerB = $row['answer_b'];
							$answerC = $row['answer_c'];
							$answerD = $row['answer_d'];
							$valueA = $row['value_a'];
							$valueB = $row['value_b'];
							$valueC = $row['value_c'];
							$valueD = $row['value_d'];
							$choiseAnswer = $row['choice_answer'];
							$activeFlag = $row['q_active_flag'];

							$rightAnswer = "";
							if ($valueA == 10) {
								$rightAnswer = "A";
							} else if ($valueB == 10) {
								$rightAnswer = "B";
							} else if ($valueC == 10) {
								$rightAnswer = "C";
							} else if ($valueD == 10) {
								$rightAnswer = "D";
							}
							
							if($i >1){
								echo "<hr>";
							}
						?>
						<div class="row">
							<form role="form">
								<div class="col-md-12">
									<div class="form-group">
										<label><?php echo $i++; ?>. <?php echo $questionText; ?></label>
									</div>
								</div>
								<div class="col-md-12">

									<div class="form-group" 
									<?php
										if ($rightAnswer == 'A') { echo 'style="color: rgb(32, 184, 74);"';
										}
 									?>>
										<label>(A) </label>
										<?php
										echo $answerA;
										if ($rightAnswer == 'A') {
											echo ' <i class="fa fa-check"></i> ';
										}
										?>
										
									</div>
									<div class="form-group" 
									<?php
										if ($rightAnswer == 'B') { echo 'style="color: rgb(32, 184, 74);"';
										}
 									?>>
										<label>(B) </label>
										<?php echo $answerB;
											if ($rightAnswer == 'B') {
												echo ' <i class="fa fa-check"></i> ';
											}
										?>
									</div>
									<div class="form-group" 
									<?php
										if ($rightAnswer == 'C') { echo 'style="color: rgb(32, 184, 74);"';
										}
 									?>>
										<label>(C) </label>
										<?php echo $answerC;
											if ($rightAnswer == 'C') {
												echo ' <i class="fa fa-check"></i> ';
											}
										?>
									</div>
									<div class="form-group" <?php
										if ($rightAnswer == 'D') { echo 'style="color: rgb(32, 184, 74);"';
										}
 									?>>
										<label>(D) </span></label>
										<?php echo $answerD;
											if ($rightAnswer == 'D') {
												echo ' <i class="fa fa-check"></i> ';
											}
										?>
									</div>
									<div class="form-group">
										<label>Status</label>
										: <?php echo '<span class="label label-' . ($activeFlag==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span>' ?>
									</div>
								</div>
								<div class="col-md-12 text-right">
									<a class="btn btn-primary" href="home.php?menu=question-edit&id=<?php echo $question_id; ?>&id=<?php echo $category_id; ?>"><i class="fa fa-edit"></i>&nbsp;Edit</a>
									<?php if($activeFlag==1){
									?>
									<a class="btn btn-danger" href="home.php?menu=active-flag&id=<?php echo $question_id; ?>&flag=0&type=question&cd=<?php echo $category_id; ?>"><i class="fa fa-lock"></i>&nbsp;Non Aktifkan</a>
									<?php }else{ ?>
									<a class="btn btn-success" href="home.php?menu=active-flag&id=<?php echo $question_id; ?>&flag=1&type=question&cd=<?php echo $category_id; ?>"><i class="fa fa-unlock"></i>&nbsp;Aktifkan</a>
									<?php } ?>
								</div>
							</form>
						</div>
						<?php
						}
						if($i == 1){
							echo "<div>Belum diinputkan data pertanyaan</div>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
