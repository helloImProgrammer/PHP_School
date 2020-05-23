<?php
session_start();

include 'ayar.php';


$TSid = $_SESSION['TSid'];



?>



<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Derslerim</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Salihli Meslek Yüksekokulu</h1>
				<a href="home.php"><i class="fas fa-home"></i>Anasayfa</a>
				<a><?php if ($_SESSION['TSid']== 1){echo '<a href="addLecture.php"><i class="fas fa-user-circle"></i>Ders Ekleme</a>';}?></a>
				<a href="lectures.php"><i class="fas fa-user-circle"></i>Derslerim</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Hesap Bilgileri</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış</a>
			</div>
		</nav>
		<div class="content">
			<h2>Ders Bilgileri</h2>
			<div>
				<p>Dersleriniz ve Sınav Şekliniz aşağıdaki gibidir</p>
								


								<?php
									$sorgu1 = mysqli_query($con , "SELECT * FROM examsdate");
									if($sorgu1){
									while($read = mysqli_fetch_array($sorgu1)){
										$startdate  = $read['exam_start_date'];
										$finish_date = $read['exam_finish_date'];
										$examActive = $read['exam_acitve_date'];
									}
								}
									
								// date("Y-m-d")
								if(!empty($startdate) && !empty($finish_date)){
									if(strtotime($startdate)<=strtotime(date("Y-m-d")) &&   strtotime(date("Y-m-d")) <= strtotime($finish_date) && $examActive == 1){
							
										///Bu sorgu bize 3lü bir küme oluşturur LEFT JOIN kısmından bize lectures tablosunun exams ile kesişmediği kısmı almamızı sağlar
										//INNER JOIN tarafından da bize bu değerlerin hangi bölümlerde olduğunu almamızı sağlar.
										$sonuc = mysqli_query($con,'SELECT lectures.Lid,lectures.Lcode,lectures.Lname,lectures.Pid,programs.Pname FROM ((lectures
										LEFT JOIN exams ON lectures.Lid = exams.Lid)INNER JOIN programs on lectures.Pid=programs.Pid) 
										WHERE exams.Eid is not null and lectures.TSid='.$TSid);  
										
										
										$message=''; 
										
										?> 
										<form action="" method="post">
										<select name="exams" id="exams">
										<option >Lütfen bir ders seçiniz</option>
										<?PHP 

										if(mysqli_num_rows($sonuc)>0){ //$sonuc sorgusundan dönen satır sayısı 0 ın üstünde ise bize dönen derslerin
										while( $row = mysqli_fetch_array( $sonuc ) ){ ?> 	<!-- Listesini verir -->	
										<option value="<?php echo $row[0] ?>" ><?PHP echo $row['Lcode']." - ".$row['Lname']." - ".$row['Pname']  ; ?></option>
											
										
										  <?PHP } }
											else{		// eğer satır dönmediyse alttaki mesaj basılır
												$message='Sınav şekli değiştirilecek ders bulunamadı';
											}
											
											$sign_up = '';
											
											if(isset($_POST['update'])){	
											$Lid = $_POST['exams']; 

											$sorgu = mysqli_query($con,'SELECT Pid FROM lectures WHERE Lid='.$Lid);	
																//Buradan seçilen dersin exam tablosuna kaydı için Pid değeri döner ders idsine göre
											$read = mysqli_fetch_array($sorgu);

											$Pid = $read[0];	//dönen değerdeki 0 indeksine sahip değer Pid'dir

											$Etypeid = $_POST['etype']; 
											
											$sorgu = "UPDATE exams SET ETypeid = ".$Etypeid." WHERE Lid=".$Lid;
																	//exam tablosunun update sorgusu
											$sonuc = mysqli_query($con,$sorgu);
											
											

											if ($sonuc){	//update başarılı ise alttaki mesaj basılır
												$sign_up = 'Güncelleme işleminiz başarılı';
												header("Refresh:1; url='examsUpdate.php'");
												unset($_POST);	//ve $_POST dizisinin içi silinir

											}
                                            }
                                            
										  ?>   
										  </select>
										
															
															<p>
															<input type="radio" name="etype" value="1"/>Test<br/>
															<input type="radio" name="etype" value="2"/>Klasik Sınav<br/>
															<input type="radio" name="etype" value="3"/>Uygulama<br/>
															<input type="radio" name="etype" value="4"/>Proje Teslim<br/>
															<input type="hidden" name="submit" value="1"/> 
															</p>
															<p><input type="submit" name="update" value="GÜNCELLE"/><br/>
															</form>
														
												<?php
												  }else{
													$message="Sınav Kayıt Tarihi Bitti.";
													$sign_up = "";
												}}else{
													$message="Sınav Kayıt Tarihi belirlenmedi.";
													$sign_up = "";
												}
													
												echo $message;
												echo $sign_up;												  
								
												
										  
										?>


			</div>
		</div>
	</body>
</html>