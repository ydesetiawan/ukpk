<?php
session_start();
if (isset($_GET['allowedTest'])) {
	$_SESSION['allowedTest'] = $_GET['allowedTest'];
} else {
	$_SESSION['allowedTest'] = 0;
}
?>