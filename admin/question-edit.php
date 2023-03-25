<?php
include 'database.php';
$pdo = Database::connect();
$question_id = $_GET['id'];
$category_detail = $_GET['cd'];
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

$value = "";
if ($valueA == 10) {
	$value = "A";
} else if ($valueB == 10) {
	$value = "B";
} else if ($valueC == 10) {
	$value = "C";
} else if ($valueD == 10) {
	$value = "D";
}

if (!empty($_POST)) {
	$categoryNameError = null;
	$questionTextError = null;
	$answerAError = null;
	$answerBError = null;
	$answerCError = null;
	$answerDError = null;
	$valueError = null;

	$category_detail = $_POST['cd'];

	$categoryName = $_POST['categoryName'];
	$questionText = $_POST['questionText'];
	$answerA = $_POST['answerA'];
	$answerB = $_POST['answerB'];
	$answerC = $_POST['answerC'];
	$answerD = $_POST['answerD'];
	$value = $_POST['value'];

	$valid = true;
	if (empty($categoryName)) {
		$categoryNameError = 'Dimohon untuk memasukkan Tipe Pertanyaan!';
		$valid = false;
	}
	if (empty($questionText)) {
		$questionTextError = 'Dimohon untuk memasukkan Text Pertanyaan!';
		$valid = false;
	}
	if (empty($answerA)) {
		$answerAError = 'Dimohon untuk memasukkan Pertanyaan A!';
		$valid = false;
	}
	if (empty($answerB)) {
		$answerBError = 'Dimohon untuk memasukkan Pertanyaan B!';
		$valid = false;
	}
	if (empty($answerC)) {
		$answerCError = 'Dimohon untuk memasukkanPertanyaan C!';
		$valid = false;
	}
	if (empty($answerD)) {
		$answerDError = 'Dimohon untuk memasukkan Pertanyaan D!';
		$valid = false;
	}
	if (empty($value)) {
		$valueError = 'Dimohon untuk memilh salah satu jawaban yang bernilai benar!';
		$valid = false;
	}

	if ($valid) {

		$valueA = 0;
		$valueB = 0;
		$valueC = 0;
		$valueD = 0;

		if ($value == 'A') {
			$valueA = 10;
		} else if ($value == 'B') {
			$valueB = 10;
		} else if ($value == 'C') {
			$valueC = 10;
		} else if ($value == 'D') {
			$valueD = 10;
		}

		$pdo = Database::connect();
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE question SET question_text=?, category_id=?, answer_a=?, answer_b=?, answer_c=?, answer_d=?, value_a=?, value_b=?, value_c=?, value_d=? WHERE question_id = ?";
		$q = $pdo -> prepare($sql);
		$q -> execute(array($questionText, $categoryName, $answerA, $answerB, $answerC, $answerD, $valueA, $valueB, $valueC, $valueD, $question_id));
		Database::disconnect();

		if (empty($category_detail)) {
			
			echo "<script>window.location.href='home.php?menu=question-detail&id=$question_id';</script>";
			exit;
		} else {
			
			echo "<script>window.location.href='home.php?menu=category-detail&id=$question_id';</script>";
			exit;
		}
	}
}

$pdo = Database::connect();
$sql = 'SELECT * FROM category WHERE active_flag = 1';
$count = $pdo -> query($sql) -> fetchColumn();
$i = 1;
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
						Edit Data Pertanyaan	Uji Kompetensi
					</div>
					<div class="panel-body">
						<div class="row">
							<form role="form" action="home.php?menu=question-edit&id=<?php echo $question_id; ?>" method="post">
								<div class="col-md-12">
									<h3>Pertanyaan</h3>
									<div class="form-group <?php echo !empty($categoryNameError) ? 'has-error' : ''; ?>">
										<label>Kategori Uji Kompetensi*<span class="labelError"> <?php echo !empty($categoryNameError) ? $categoryNameError : ''; ?></span></label>
										<select class="form-control" name="categoryName">
											<?php
											foreach ($pdo->query($sql) as $row) {
												$selected="";
												if($questionDetail['category_id'] ==$row['category_id']){
													$selected = "selected"
;												}
												echo '<option value=' . $row['category_id'].' '.$selected . '>' . $row['category_name'] . '</option>';
											}
											Database::disconnect();
											?>
										</select>
									</div>
									<div class="form-group <?php echo !empty($questionTextError) ? 'has-error' : ''; ?>">
										<label>Text Pertanyaan*<span class="labelError"> <?php echo !empty($questionTextError) ? $questionTextError : ''; ?></span></label>
										<textarea class="form-control" rows="3" name="questionText"><?php echo $questionText; ?></textarea>
									</div>
									<h3>Jawaban </h3>
								</div>
								<div class="col-md-6">

									<div class="form-group <?php echo !empty($answerAError) ? 'has-error' : ''; ?>">
										<label>Jawaban A*<span class="labelError"> <?php echo !empty($answerAError) ? $answerAError : ''; ?></span></label>
										<textarea class="form-control" rows="3" name="answerA"><?php echo $answerA; ?></textarea>
										<div class="radio">
											<label>
												<input type="radio" name="value" value="A" <?php echo $value=="A" ? 'checked' : '' ?>/>
												Pilih jawaban A jika bernilai benar </label>
										</div>
										<span class="labelError"> <?php echo !empty($valueError) ? $valueError : ''; ?></span>
									</div>
									<hr>
									<div class="form-group <?php echo !empty($answerBError) ? 'has-error' : ''; ?>">
										<label>Jawaban B*<span class="labelError"> <?php echo !empty($answerBError) ? $answerBError : ''; ?></span></label>
										<textarea class="form-control" rows="3" name="answerB"><?php echo $answerB; ?></textarea>
										<div class="radio">
											<label>
												<input type="radio" name="value" value="B" <?php echo $value=="B" ? 'checked' : '' ?>/>
												Pilih jawaban B jika bernilai benar </label>
										</div>
										<span class="labelError"> <?php echo !empty($valueError) ? $valueError : ''; ?></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group <?php echo !empty($answerCError) ? 'has-error' : ''; ?>">
										<label>Jawaban C*<span class="labelError"> <?php echo !empty($answerCError) ? $answerCError : ''; ?></span></label>
										<textarea class="form-control" rows="3" name="answerC"><?php echo $answerC; ?></textarea>
										<div class="radio">
											<label>
												<input type="radio" name="value" value="C" <?php echo $value=="C" ? 'checked' : '' ?>/>
												Pilih jawaban C jika bernilai benar </label>
										</div>
										<span class="labelError"> <?php echo !empty($valueError) ? $valueError : ''; ?></span>
									</div>
									<hr>
									<div class="form-group <?php echo !empty($answerDError) ? 'has-error' : ''; ?>">
										<label>Jawaban D*<span class="labelError"> <?php echo !empty($answerDError) ? $answerDError : ''; ?></span></label>
										<textarea class="form-control" rows="3" name="answerD"><?php echo $answerD; ?></textarea>
										<div class="radio">
											<label>
												<input type="radio" name="value" value="D" <?php echo $value=="D" ? 'checked' : '' ?>/>
												Pilih jawaban D jika bernilai benar </label>
										</div>
										<span class="labelError"> <?php echo !empty($valueError) ? $valueError : ''; ?></span>
									</div>
								</div>
								<input type="hidden" name="cd" value="<?php echo $category_detail; ?>" />
								<div class="col-md-12 text-right">
									<button type="submit" class="btn btn-primary">
										Simpan
									</button>
									<button type="reset" class="btn btn-default">
										Ulang
									</button>
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