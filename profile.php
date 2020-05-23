<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
include 'ayar.php';

$stmt = $con->prepare('SELECT password, email FROM teachingstafs WHERE TSid = ?');
//Session bilgileri // Bind parametreleri (s = string, i = int, b = blob, vb.), bizim aşağıdaki cümlemizde TSid int olduğu için i harfi kullanılacak
$stmt->bind_param('i', $_SESSION['TSid']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Hesap Bilgileri</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Salihli Meslek Yüksekokulu</h1>
				<a href="home.php"><i class="fas fa-home"></i>Anasayfa</a>
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
			<h2>Kullanıcı Bilgileri</h2>
			<div>
				<p>Hesabınızın Detayları aşağıdaki gibidir</p>
				<table>
					<tr>
						<td>Kullanıcı Adı:</td>
						<td><?=$_SESSION['TSname'] . " " . $_SESSION['TSsurname']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$_SESSION['email']?></td>
						
					</tr>
					
				</table>
			</div>
		</div>
	</body>
</html>