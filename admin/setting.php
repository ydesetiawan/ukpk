<?php
$r_minimum_value = 'ukpk.minimimum_value=' . $ini_minimum_value;
$r_ukpk_year = 'ukpk.year=' . $ini_ukpk_year;
$r_ukpk_month = 'ukpk.month=' . $ini_ukpk_month;
$r_ukpk_day = 'ukpk.day=' . $ini_ukpk_day;
$r_ukpk_hour = 'ukpk.hour=' . $ini_ukpk_hour;
$r_ukpk_minute = 'ukpk.minute=' . $ini_ukpk_minute;
$r_ukpk_secound = 'ukpk.secound=' . $ini_ukpk_secound;
$r_ukpk_long_hour = 'ukpk.long_hour=' . $ini_ukpk_long_hour;
$r_ukpk_long_minute = 'ukpk.long_minute=' . $ini_ukpk_long_minute;
$r_ukpk_long_secound = 'ukpk.long_secound=' . $ini_ukpk_long_secound;

if (!empty($_POST)) {
	$fname = "assets/conf.ini";
	// $fhandle = fopen($fname, "r");
	// $content = fread($fhandle, filesize($fname));

	// Open the file to get existing content
	$content = file_get_contents($fname);

	$w_minimum_value = 'ukpk.minimimum_value=' . $_POST['minimum_value'];
	$w_ukpk_year = 'ukpk.year=' . $_POST['ukpk_year'];
	$w_ukpk_month = 'ukpk.month=' . $_POST['ukpk_month'];
	$w_ukpk_day = 'ukpk.day=' . $_POST['ukpk_day'];
	$w_ukpk_hour = 'ukpk.hour=' . $_POST['ukpk_hour'];
	$w_ukpk_minute = 'ukpk.minute=' . $_POST['ukpk_minute'];
	$w_ukpk_secound = 'ukpk.secound=' . $_POST['ukpk_secound'];
	$w_ukpk_long_hour = 'ukpk.long_hour=' . $_POST['ukpk_long_hour'];
	$w_ukpk_long_minute = 'ukpk.long_minute=' . $_POST['ukpk_long_minute'];
	$w_ukpk_long_secound = 'ukpk.long_secound=' . $_POST['ukpk_long_secound'];

	$content = str_replace($r_minimum_value, $w_minimum_value, $content);
	$content = str_replace($r_ukpk_year, $w_ukpk_year, $content);
	$content = str_replace($r_ukpk_month, $w_ukpk_month, $content);
	$content = str_replace($r_ukpk_day, $w_ukpk_day, $content);
	$content = str_replace($r_ukpk_hour, $w_ukpk_hour, $content);
	$content = str_replace($r_ukpk_minute, $w_ukpk_minute, $content);
	$content = str_replace($r_ukpk_secound, $w_ukpk_secound, $content);
	$content = str_replace($r_ukpk_long_hour, $w_ukpk_long_hour, $content);
	$content = str_replace($r_ukpk_long_minute, $w_ukpk_long_minute, $content);
	$content = str_replace($r_ukpk_long_secound, $w_ukpk_long_secound, $content);

	file_put_contents($fname, $content);

	header("Location: home.php?menu=setting&flag=1");
}
?>

<!-- /. PAGE WRAPPER  -->
<div id="page-wrapper" >
	<!-- /. PAGE INNER  -->
	<div id="page-inner">
		<div class="row">
			<form role="form" action="home.php?menu=setting" method="post">
				<div class="col-md-6 col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							Pengaturan
						</div>
						<div class="panel-body">

							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#value-pills" data-toggle="tab">Nilai Minimum</a>
								</li>
								<li class="">
									<a href="#date-test-pills" data-toggle="tab">Tanggal dan Waktu</a>
								</li>
								<li class="">
									<a href="#time-test-pills" data-toggle="tab">Durasi</a>
								</li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane fade active in" id="value-pills">
									<br>
									<div class="form-group col-md-6" >
										<label>Nilai Minimum</label>
										<input class="form-control" name="minimum_value" value="<?php echo $ini_minimum_value; ?>"/>
									</div>
								</div>
								<div class="tab-pane fade" id="date-test-pills">
									<br>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group" >
												<label>Tahun</label>
												<select class="form-control" name="ukpk_year">
													<?php
													for ($i = 2023; $i <= 2025; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_year) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group" >
												<label>Bulan</label>
												<select class="form-control" name="ukpk_month">
													<?php
													for ($i = 1; $i <= 12; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_month) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group" >
												<label>Tanggal</label>
												<select class="form-control" name="ukpk_day">
													<?php
													for ($i = 1; $i <= 31; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_day) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group" >
												<label>Jam</label>
												<select class="form-control" name="ukpk_hour">
													<?php
													for ($i = 0; $i <= 24; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_hour) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group" >
												<label>Menit</label>
												<select class="form-control" name="ukpk_minute">
													<?php
													for ($i = 0; $i <= 60; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_minute) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group" >
												<label>Detik</label>
												<select class="form-control" name="ukpk_secound">
													<?php
													for ($i = 0; $i <= 60; $i++) {
														$selected = "";
														if ($i == $ini_ukpk_secound) {
															$selected = "selected";
														}
														echo '<option ' . $selected . '>' . $i . '</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="time-test-pills">
									<br>
									<div class="col-md-6">
										<div class="form-group" >
											<label>Jam</label>
											<select class="form-control" name="ukpk_long_hour">
												<?php
												for ($i = 0; $i <= 24; $i++) {
													$selected = "";
													if ($i == $ini_ukpk_long_hour) {
														$selected = "selected";
													}
													echo '<option ' . $selected . '>' . $i . '</option>';
												}
												?>
											</select>
										</div>
										<div class="form-group" >
											<label>Menit</label>
											<select class="form-control" name="ukpk_long_minute">
												<?php
												for ($i = 0; $i <= 60; $i++) {
													$selected = "";
													if ($i == $ini_ukpk_long_minute) {
														$selected = "selected";
													}
													echo '<option ' . $selected . '>' . $i . '</option>';
												}
												?>
											</select>
										</div>
										<div class="form-group" >
											<label>Detik</label>
											<select class="form-control" name="ukpk_long_secound">
												<?php
												for ($i = 0; $i <= 60; $i++) {
													$selected = "";
													if ($i == $ini_ukpk_long_secound) {
														$selected = "selected";
													}
													echo '<option ' . $selected . '>' . $i . '</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-footer text-right">
							<?php
							if (!empty($_GET['flag'])) {
								echo '<span '.$colorGreen.'>'.$iconCheck.' Data berhasil di edit </span>';
							}
							?>
							<button type="submit" class="btn btn-primary">
								Simpan
							</button>
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
