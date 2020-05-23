<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Salihli Meslek Yüksekokulu</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Salihli Meslek Yüksekokulu</h1>
				<a><?php if ($_SESSION['TSid']== 1){echo '<a href="addLecture.php"><i class="fas fa-user-circle"></i>Ders Ekleme</a>';}?></a>
				<a><?php if ($_SESSION['TSid']== 1){echo '<a href="exams.php"><i class="fas fa-user-circle"></i>Sınavlar</a>';}?></a>
				<a><?php if ($_SESSION['TSid']!= 1){echo '<a href="lectures.php"><i class="fas fa-user-circle"></i>Derslerim</a>';}?></a>
				<a><?php if ($_SESSION['TSid']!= 1){echo '<a href="examsUpdate.php"><i class="fas fa-user-circle"></i>Sınav Güncelle</a>';}?></a>
				<a><?php if ($_SESSION['TSid']== 1){echo '<a href="teachingStaffs.php"><i class="fas fa-user-circle"></i>Öğretim Kadrosu</a>';}?></a>
				<a><?php if ($_SESSION['TSid']== 1){echo '<a href="examDate.php"><i class="fas fa-user-circle"></i>Sınav Dönemi</a>';}?></a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Hesap Bilgileri</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış</a>
			</div>
		</nav>
		<div class="content">
			<h2>Anasayfa</h2>
			<p>Hoşgeldin, <?=$_SESSION['TSname']?>!</p>
			
		</div>
	</body>
</html>