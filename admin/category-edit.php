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

if (!empty($_POST)) {
	$categoryNameError = null;

	$category_name = $_POST['category_name'];
	$description = $_POST['description'];

	$valid = true;
	if (empty($category_name)) {
		$categoryNameError = 'Dimohon untuk memasukkan Nama Kategori!';
		$valid = false;
	}

	if ($valid) {
		$sql = "UPDATE category SET category_name=?, description=? WHERE category_id = ? ";
		$q = $pdo -> prepare($sql);
		$q -> execute(array($category_name, $description,$category_id));
		
		echo "<script>window.location.href='home.php?menu=category-detail&id=$category_id';</script>";
		exit;
	}
}
Database::disconnect();
?>
<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default" >
					<div class="panel-heading">
					 Edit Data Kategori Uji Kompetensi
					</div>
					<div class="panel-body" >
						<div class="row" >
							<form role="form" action="home.php?menu=category-edit&id=<?php echo $category_id;?>" method="post">
								<div class="col-md-12">
									<div class="form-group <?php echo !empty($categoryNameError) ? 'has-error' : ''; ?>" >
										<label>Nama Kategori* <span class="labelError"> <?php echo !empty($categoryNameError) ? $categoryNameError : ''; ?></span></label>
										<input class="form-control" name="category_name" value="<?php echo $category_name; ?>"/>
									</div>
									<div class="form-group">
										<label>Keterangan</label>
										<input class="form-control" name="description" value="<?php echo $description; ?>"/>
									</div>
								</div>
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
			</div>
		</div>
	</div>
</div>
