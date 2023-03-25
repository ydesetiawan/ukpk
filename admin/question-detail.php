<?php
include 'database.php';
$pdo = Database::connect();
$question_id = $_GET['id'];
$sql = 'SELECT *,q.active_flag as q_active_flag FROM question q,category c WHERE q.category_id = c.category_id and q.question_id = ?';
$q = $pdo -> prepare($sql);
$q -> execute(array($question_id));
$questionDetail = $q -> fetch(PDO::FETCH_ASSOC);

$categoryName = $questionDetail['category_name'];
$questionText = $questionDetail['question_text'];
$answerA = $questionDetail['answer_a'];
$answerB = $questionDetail['answer_b'];
$answerC = $questionDetail['answer_c'];
$answerD = $questionDetail['answer_d'];
$valueA = $questionDetail['value_a'];
$valueB = $questionDetail['value_b'];
$valueC = $questionDetail['value_c'];
$valueD = $questionDetail['value_d'];
$activeFlag = $questionDetail['q_active_flag'];

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
						Detail Data Pertanyaan	Uji Kompetensi</strong>
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form">
								
								<div class="col-md-12">
									<h3>Uji Kompetensi : <strong><?php echo $categoryName ?></strong></h3>
									<div class="form-group">
										<label>Status : </label> <?php echo '<span class="label label-' . ($activeFlag==1 ? 'success"> Aktif' : 'danger"> Non Aktif' ). '</span>' ?>
									</div>
									<h3>Pertanyaan</h3>
									<div class="form-group">
										<label><?php echo $questionText; ?></label>
									</div>
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
								</div>
								<div class="col-md-12 text-right">
									<a class="btn btn-primary" href="home.php?menu=question-edit&id=<?php echo $question_id; ?>"><i class="fa fa-edit"></i>&nbsp;Edit</a>
									<?php if($activeFlag==1){
									?>
									<a class="btn btn-danger" href="home.php?menu=active-flag&id=<?php echo $question_id; ?>&flag=0&type=question"><i class="fa fa-lock"></i>&nbsp;Non Aktifkan</a>
									<?php }else{ ?>
									<a class="btn btn-success" href="home.php?menu=active-flag&id=<?php echo $question_id; ?>&flag=1&type=question"><i class="fa fa-unlock"></i>&nbsp;Aktifkan</a>
									<?php } ?>
									<a class="btn btn-warning" href="home.php?menu=question-list"><i class="fa fa-reply"></i>&nbsp;Kembali</a>

								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
		</div>
	</div>
</div>