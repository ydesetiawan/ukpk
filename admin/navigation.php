<?php
$activemenu1 = "";
$activemenu2 = "";
$activemenu3 = "";
$activemenu4 = "";
$activemenu5 = "";
$collapsemenu1 = "collapse";
$collapsemenu2 = "collapse";
$collapsemenu3 = "collapse";

if (empty($menu)) {
	$activemenu1 = "active-menu";
} else {
	//employee
	if ($menu == 'employee-add' || $menu == 'employee-list' || $menu == 'employee-detail' || $menu == 'employee-edit') {
		$activemenu2 = "active-menu";
		$collapsemenu1 = "collapse in";
		//question type
	} else if ($menu == 'category-add' || $menu == 'category-list' || $menu == 'category-edit' || $menu == 'category-detail') {
		$activemenu3 = "active-menu";
		$collapsemenu2 = "collapse in";
		//question
	} else if ($menu == 'question-add' || $menu == 'question-list' || $menu == 'question-edit' || $menu == 'question-detail') {
		$activemenu4 = "active-menu";
		$collapsemenu3 = "collapse in";
		//result
	} else if ($menu == 'result-list' || $menu == 'result-category-detail' || $menu == 'result-answer-detail') {
		$activemenu5 = "active-menu";
	} else if ($menu == 'setting') {
		$activemenu6 = "active-menu";
	}
}
?>
<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">Admin</a>
	</div>
	<div style="color: white;
	padding: 15px 50px 5px 50px;
	float: right;
	font-size: 16px;">
		<a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
	</div>
</nav>
<nav class="navbar-default navbar-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="main-menu">
			<li class="text-center">
				<img src="assets/img/find_user.png" class="user-image img-responsive"/>
			</li>
			</li>
			<li>
				<a class="<?php echo $activemenu1; ?>"  href="home.php"><i class="fa fa-dashboard fa-3x"></i> Beranda</a>
			</li>
			<li>
				<a href="#" class="<?php echo $activemenu2; ?>"><i class="glyphicon glyphicon-user fa-3x"></i> Calon Karyawan<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level <?php echo $collapsemenu1; ?>">
					<li>
						<a  href="home.php?menu=employee-add">Tambah Data Calon Karyawan</a>
					</li>
					<li>
						<a href="home.php?menu=employee-list">Lihat Data Calon Karyawan</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="<?php echo $activemenu3; ?>"><i class="fa fa-edit fa-3x"></i> Kategori Uji Kompetensi<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level <?php echo $collapsemenu2; ?>">
					<li>
						<a href="home.php?menu=category-add">Tambah Data Kategori</a>
					</li>
					<li>
						<a href="home.php?menu=category-list">Lihat Data Kategori</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="<?php echo $activemenu4; ?>"><i class="fa fa-edit fa-3x"></i> Pertanyaan Uji Kompetensi<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level <?php echo $collapsemenu3; ?>">
					<li>
						<a href="home.php?menu=question-add">Tambah Data Petanyaan</a>
					</li>
					<li>
						<a href="home.php?menu=question-list">Lihat Data Pertanyaan</a>
					</li>
				</ul>
			</li>
			<li>
				<a class="<?php echo $activemenu5; ?>"  href="home.php?menu=result-list"><i class="fa fa-bar-chart-o fa-3x"></i> Hasil Uji Kompetensi</a>
			</li>
			<li>
				<a class="<?php echo $activemenu6; ?>"  href="home.php?menu=setting"><i class="fa fa-cogs fa-3x"></i> Pengaturan</a>
			</li>
		</ul>
		</ul>
	</div>
</nav>