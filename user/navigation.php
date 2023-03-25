<?php
$activemenu1 = "";
$activemenu2 = "";
$collapsemenu1 = "collapse";
$collapsemenu2 = "collapse";

if (empty($menu)) {
	$activemenu1 = "active-menu";
} else {
	//test
	if ($menu == 'test' || $menu == 'start-test' || $menu == 'finish-test' ) {
		$activemenu1 = "active-menu";
		//result
	} else if ($menu == 'print') {
		$activemenu1 = "active-menu";
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
		<a class="navbar-brand" href="#"><?php echo $user_name; ?></a>
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
				<a class="<?php echo $activemenu1; ?>" href="home.php?menu=test"><i class="fa fa-edit fa-3x"></i> Uji Kompetensi</a>
			</li>
		</ul>
	</div>
</nav>