<?php
include 'database.php';
$pdo = Database::connect();
$category_id = $_GET['id'];
$user_detail_id = $_GET['userid'];
//$sql = "SELECT * FROM answer a,question q,category c WHERE q.category_id = '$category_id' and a.question_id = q.question_id and a.user_detail_id='$user_detail_id' GROUP BY a.question_id";
$sql_question = "SELECT * FROM question q,category c WHERE q.category_id =c.category_id and q.category_id = '$category_id'";
$countQuestion = $pdo -> query($sql_question) -> rowCount();

$sql_category = "SELECT * FROM category c WHERE c.category_id = ?";
$q = $pdo -> prepare($sql_category);
$q -> execute(array($category_id));
$categoryDetail = $q -> fetch(PDO::FETCH_ASSOC);

$sql_user_detail = "SELECT * FROM user_detail ud WHERE ud.user_detail_id = ?";
$q = $pdo -> prepare($sql_user_detail);
$q -> execute(array($user_detail_id));
$userDetail = $q -> fetch(PDO::FETCH_ASSOC);

$sql_result = "SELECT sum(a.value) as total_value FROM answer a,question q,category c WHERE q.category_id = c.category_id and a.question_id = q.question_id and a.user_detail_id=? and c.category_id=? GROUP BY q.category_id";
$q = $pdo -> prepare($sql_result);
$q -> execute(array($user_detail_id, $category_id));
$result = $q -> fetch(PDO::FETCH_ASSOC);

Database::disconnect();
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- Form Elements -->
				<div class="panel panel-default">
					<div class="panel-heading">
						Detail Data Jawaban	Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form">
								<div class="col-md-12">
									<h3>Uji Kompetensi : <strong><?php echo $categoryDetail['category_name']; ?></strong></h3>
									<div class="form-group">
										<label>ID Pendaftar : </label> <?php echo $userDetail['register_id']; ?>
										<br>
										<label>Nama Calon Karyawan : </label> <?php echo $userDetail['name']; ?>
										<br>
										<label>Total Soal : </label> <?php echo $countQuestion; ?>
										<br>
										<label>Jawaban benar : </label> <?php echo $result['total_value'] / 10; ?>
										<br>
										<label>Nilai : </label> <?php echo ($result['total_value']/$countQuestion)*10 ?>
									</div>
								</div>
							</form>
						</div>
						<?php
						$i = 1;
						foreach ($pdo->query($sql_question) as $row) {
							$questionId = $row['question_id'];
							$categoryName = $row['category_name'];
							$questionText = $row['question_text'];
							$answerA = $row['answer_a'];
							$answerB = $row['answer_b'];
							$answerC = $row['answer_c'];
							$answerD = $row['answer_d'];
							$valueA = $row['value_a'];
							$valueB = $row['value_b'];
							$valueC = $row['value_c'];
							$valueD = $row['value_d'];

							$sql_answered = "SELECT * FROM answer a WHERE a.question_id = ? and a.user_detail_id = ?";
							$q = $pdo -> prepare($sql_answered);
							$q -> execute(array($questionId, $user_detail_id));
							$questioAnswered = $q -> fetch(PDO::FETCH_ASSOC);
							$choiseAnswer = '';

							if (!empty($questioAnswered)) {
								$choiseAnswer = $questioAnswered['choice_answer'];
							}

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
							echo '<hr>
						<div class="row">
							<form role="form">';
							if ($choiseAnswer == '') {
								echo '<div class="col-md-12"' . $colorRed . '>
											<div class="form-group text-center">
												<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button> Pertanyaan belum dijawab
											</div>
										  </div>';
							}
							if ($choiseAnswer != $rightAnswer && $choiseAnswer != '') {
								echo '<div class="col-md-12"' . $colorRed . '>
											<div class="form-group text-center">
												<button type="button" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></button> Jawaban salah
											</div>
										  </div>';
							}
							if ($choiseAnswer == $rightAnswer) {
								echo '<div class="col-md-12"' . $colorGreen . '>
											<div class="form-group text-center">
												<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i>
                            					</button> Jawaban benar
											</div>
										  </div>';
							}
							echo '<div class="col-md-12">
										 <div class="form-group">
											<label>' . $i++ . '. ' . $questionText . '</label>
										</div>
									  </div>
									  <div class="col-md-12">';
							echo '<div class="form-group"';
							if ($choiseAnswer == $rightAnswer && $choiseAnswer == 'A') { echo $colorGreen . '>';
							} else if ($choiseAnswer != $rightAnswer && $choiseAnswer == 'A') { echo $colorRed . '>';
							}
							echo '<label>(A) </label> ';
							echo $answerA;
							if ($choiseAnswer == 'A' && $choiseAnswer == $rightAnswer) {
								echo $iconCheck;
							} else if ($choiseAnswer == 'A' && $choiseAnswer != $rightAnswer) {
								echo $iconTimes;
							}
							echo '</div>';
							echo '<div class="form-group"';
							if ($choiseAnswer == $rightAnswer && $choiseAnswer == 'B') { echo $colorGreen . '>';
							} else if ($choiseAnswer != $rightAnswer && $choiseAnswer == 'B') { echo $colorRed . '>';
							}
							echo '<label>(B) </label> ';
							echo $answerB;
							if ($choiseAnswer == 'B' && $choiseAnswer == $rightAnswer) {
								echo $iconCheck;
							} else if ($choiseAnswer == 'B' && $choiseAnswer != $rightAnswer) {
								echo $iconTimes;
							}
							echo '</div>';
							echo '<div class="form-group"';
							if ($choiseAnswer == $rightAnswer && $choiseAnswer == 'C') { echo $colorGreen . '>';
							} else if ($choiseAnswer != $rightAnswer && $choiseAnswer == 'C') { echo $colorRed . '>';
							}
							echo '<label>(C) </label> ';
							echo $answerC;
							if ($choiseAnswer == 'C' && $choiseAnswer == $rightAnswer) {
								echo $iconCheck;
							} else if ($choiseAnswer == 'C' && $choiseAnswer != $rightAnswer) {
								echo $iconTimes;
							}
							echo '</div>';
							echo '<div class="form-group"';
							if ($choiseAnswer == $rightAnswer && $choiseAnswer == 'D') { echo $colorGreen . '>';
							} else if ($choiseAnswer != $rightAnswer && $choiseAnswer == 'D') { echo $colorRed . '>';
							}
							echo '<label>(D) </label> ';
							echo $answerD;
							if ($choiseAnswer == 'D' && $choiseAnswer == $rightAnswer) {
								echo $iconCheck;
							} else if ($choiseAnswer == 'D' && $choiseAnswer != $rightAnswer) {
								echo $iconTimes;
							}
							echo '</div>';
							echo '</div>';
							if ($choiseAnswer != $rightAnswer) {
								echo '<div class="col-md-12"' . $colorGreen . '>
											<div class="form-group alert alert-info">
												<i class="fa fa-key"></i> Jawaban yang benar adalah <b>' . $rightAnswer . '</b>
											</div>
										  </div>';
							}
							echo '</form>
							</div>';
						}
						?>
						<div class="col-md-12 text-right">
							<a class="btn btn-warning" href="home.php?menu=result-category-detail&id=<?php echo $user_detail_id; ?>"><i class="fa fa-reply"></i>&nbsp;Kembali</a>
						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
		</div>
	</div>
</div>