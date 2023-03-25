<?php

if($allowedTest!=1){
	header("location: home.php?menu=test");
}
include 'database.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$i = 0;
$category_id = 0;
$countAllQuestion=0;
$buttonValue = "Lanjut";
$userdetail_id = $user_id;
$question_id =0;
$valid=TRUE;

if(!empty($_POST)){
	$question_id = $_POST['question_id'];
	$value=$_POST['answer_value'];
	$choice_answer=$_POST['choice_answer'];
	
	$query_duplicate = "SELECT count(*) as duplicate FROM `answer` WHERE `user_detail_id`=? and `question_id`=?";
	$q = $pdo -> prepare($query_duplicate);
	$q -> execute(array($userdetail_id, $question_id));
	$duplicate = $q -> fetch(PDO::FETCH_ASSOC);
	
	if($value != NULL && $allowedTest=1 && $duplicate['duplicate'] == 0){
		$sql = "INSERT INTO answer (user_detail_id,question_id,value,choice_answer) values(?,?,?,?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($userdetail_id,$question_id,$value,$choice_answer));
	}else{
		$valid=FALSE;
	}
	
}

if (!empty($_GET['id'])) {
	$category_id = $_GET['id'];
	
	$sql_answered = "SELECT * FROM answer a,question q,category c WHERE c.category_id = q.category_id and c.category_id = $category_id and a.question_id = q.question_id and a.user_detail_id= $userdetail_id";
	$i = $pdo -> query($sql_answered) -> rowCount();
		
	$sql_all_question ="SELECT *,q.question_id as question_id FROM question q,category c Where q.category_id = $category_id AND c.category_id = q.category_id";
	$countAllQuestion = $pdo -> query($sql_all_question) -> rowCount();
	
	$sql = "SELECT *,q.question_id as question_id FROM question q,category c Where q.category_id = $category_id AND c.category_id = q.category_id  ";
	$limit = " LIMIT $i,1";
	$sql = $sql.$limit;
}

if($countAllQuestion == ($i+1)){
	$buttonValue = "Selesai";
}else if(($i+1) > $countAllQuestion){
	$query_answer_by_user = "SELECT a.question_id as question_id FROM answer a,question q,category c WHERE c.category_id = q.category_id and c.category_id = $category_id and a.question_id = q.question_id and a.user_detail_id= $userdetail_id";
	foreach ($pdo->query($query_answer_by_user) as $row) {
		$sql_update_answer = "UPDATE answer SET flag=1 where user_detail_id = ? and question_id = ? ";
		$q = $pdo->prepare($sql_update_answer);
		$q->execute(array($userdetail_id,$row['question_id']));
	}	

	echo "<script>window.location.href='home.php?menu=finish-test&id=$category_id';</script>";
	exit;
}

foreach ($pdo->query($sql) as $row) {
?>

<div id="page-wrapper" >
	<div id="page-inner">
		<div class="row">
			<div class="col-md-offset-4 col-md-3">
				<div id="changeSession"></div>
				<div id="beforeTimeTest" style="padding: 10px;"></div>
				<div id="startTimeTest" style="background: #428bca;color: white;  padding: 10px;"></div>
				<div id="finishTest" class="is-countdown" style="background: rgb(32, 184, 74);color: white; padding: 10px;"><center><b>Uji Kompetensi Telah Berakhir</b></center></div>
			</div>
			<div class="col-md-12">
				<h2>Uji Kompetensi : <strong><?php echo $row['category_name']; ?></strong></h2>
				<h5>Semoga berhasil dalam mengerjakan uji kompetensi penerimaan karyawan.</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<br>
		<div class="row">
			<div class="col-md-12">
				<span class="text-center"><h5> <?php echo 'Soal Nomor <b>'.($i+1).'</b> dari <b>'. $countAllQuestion.'</b> Soal';?></h5></span>
			
			</div>
			<div class="col-md-12">
				<!-- Form Elements -->
				<div class="panel panel-primary">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form action="<?php echo 'home.php?menu=start-test&id=' . $category_id . '&i=' . $i; ?>" method="post">
									<h4><?php echo $row['question_text']; ?></h4>
									<div class="form-group">
										<div class="radio">
											<label>
												<input type="radio" id="answerA" name="answer_value" value="<?php echo $row['value_a']; ?>" />
												<?php echo $row['answer_a']; ?> </label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" id="answerB" name="answer_value" value="<?php echo $row['value_b']; ?>"/>
												<?php echo $row['answer_b']; ?> </label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" id="answerC" name="answer_value" value="<?php echo $row['value_c']; ?>"/>
												<?php echo $row['answer_c']; ?> </label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" id="answerD" name="answer_value" value="<?php echo $row['value_d']; ?>"/>
												<?php echo $row['answer_d']; ?> </label>
										</div>
									</div>
									<input type="hidden" id="choice_answer" name="choice_answer"  />
									<label class="labelError"><?php echo $valid == FALSE ? 'Harus pilih jawaban terlebih dahulu!' : ''; ?></label>
									<input type="hidden" name="question_id" value="<?php echo $row['question_id']; ?>"/>
									<button type="submit" class="btn btn-primary pull-right">
										<?php echo $buttonValue; ?> <i class="glyphicon glyphicon-step-forward"></i></I>
									</button>
								</form>
								<br />
							</div>
						</div>
					</div>
					<!-- End Form Elements -->
				</div>
			</div>

			<!-- /. ROW  -->
		</div>
		<!-- /. PAGE INNER  -->
	</div>
	<!-- /. PAGE WRAPPER  -->
</div>
<?php
}
Database::disconnect();
?>