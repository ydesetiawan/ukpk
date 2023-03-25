<?php

require 'database.php';
$pdo = Database::connect();
$type = $_GET['type'];
$id = $_GET['id'];
$username = $_GET['username'];
$flag = $_GET['flag'];
$cd=$_GET['cd'];
if($type=='userdetail'){
	$sql = "UPDATE user SET active_flag = ? WHERE username= ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($flag,$username));
	
	$sql = "UPDATE user_detail SET active_flag = ? WHERE user_detail_id= ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($flag,$id));
	
	echo "<script>window.location.href='home.php?menu=employee-detail&id=$id';</script>";
	exit;
}

if($type=='category'){
	$sql = "UPDATE category SET active_flag = ? WHERE category_id= ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($flag,$id));

	echo "<script>window.location.href='home.php?menu=category-detail&id=$id';</script>";
	exit;
}

if($type=='question'){
	$sql = "UPDATE question SET active_flag = ? WHERE question_id= ?";
	$q = $pdo -> prepare($sql);
	$q -> execute(array($flag,$id));
	
	if(empty($cd)){
		echo "<script>window.location.href='home.php?menu=question-detail&id=$id';</script>";
		exit;
	}else{

		echo "<script>window.location.href='home.php?menu=category-detail&id=$id';</script>";		exit;
		exit;
	}
}


Database::disconnect();
?>

?>