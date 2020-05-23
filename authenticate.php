<?php
session_start();

include 'ayar.php';

if ( !isset($_POST['email'], $_POST['password']) ) {
	
	exit('Lütfen tüm alanları doldurun.');
}

if(isset($_POST['submit'])){
	
	session_destroy();
	$TSsurname= mb_strtolower(mysqli_real_escape_string($con,$_POST['TSsurname']),"UTF-8");
	$TSname=mb_strtolower(mysqli_real_escape_string($con,$_POST['TSname']),"UTF-8");
	$password=mysqli_real_escape_string($con,$_POST['password']);
	$security_word=mysqli_real_escape_string($con, $_POST['security_word']);
	$email=mb_strtolower(mysqli_real_escape_string($con,$_POST['email']),"UTF-8");
	$password=password_hash($password, PASSWORD_DEFAULT);
	$security_word=password_hash($security_word, PASSWORD_DEFAULT);
	if ($stmt = $con->prepare('SELECT email FROM teachingstafs WHERE email = ?')) {
	//Session bilgileri // Bind parametreleri (s = string, i = int, b = blob, vb.), bizim aşağıdaki cümlemizde TSid int olduğu için i harfi kullanılacak
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
	header('Location:uyari.php');
	}else{
		$stmt="INSERT INTO teachingstafs (email, TSname,TSsurname, password,TS_security_word) values ('$email','$TSname','$TSsurname','$password','$security_word')";
		if(mysqli_query($con,$stmt))
		{
			header('Location:home.php');
		}
	}
	
	}}else {
	



if ($stmt = $con->prepare('SELECT TSid, TSname, TSsurname, password FROM teachingstafs WHERE email = ?')) 
		{
				//Session bilgileri // Bind parametreleri (s = string, i = int, b = blob, vb.), bizim aşağıdaki cümlemizde TSid int olduğu için i harfi kullanılacak
				$stmt->bind_param('s', $_POST['email']);
				$stmt->execute();
				
				
				$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$stmt->bind_result($TSid, $TSname, $TSsurname,  $password);
				$stmt->fetch();
				
				if (password_verify($_POST['password'], $password))  {
						
						session_regenerate_id();
						
						$_SESSION['loggedin'] = TRUE;
						$_SESSION['TSname'] = $TSname;
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['TSsurname'] = $TSsurname;
						$_SESSION['program'] = $program;
						$_SESSION['TSid'] = $TSid;
						
						
						echo 'Welcome ' . $_SESSION['name'] . '!';

						header('Location:home.php');
						

					} else {
						echo 'Yanlış Şifre!';
					}
			} else 
				{
					echo 'Yanlış Kullanıcı Adı!';
				}

				$stmt->close();
		}
}

?>