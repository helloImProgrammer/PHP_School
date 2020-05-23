<?php


session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['TSid']!=1) {            //bu alana dışardan ulaşılamaması için ve id'si 1 olmayan kişi dışında giriş yapılamaz
	header('Location: index.html');
	exit;
}


include 'ayar.php';
    
    $message ='';
    if(isset($_POST['addLecture'])){
        if(empty(trim($_POST['Lname'])) || empty(trim($_POST['Lcode']))){       // Lname ve Lcode değerlerinin içinin boş olup olmadığı kontrol edildi
            $message = 'Lütfen tam doldurduğunuzdan emin olun.';
        }
        else{

            $program = $_POST['bolumler']+0;
            $sorgu1 = mysqli_query($con,'SELECT Lcode FROM lectures WHERE Pid ='.$program.' and Lcode ="'.$_POST['Lcode'].'"');
            $message2 = $sorgu1;    // Buradaki sorgu seçilen bölümde bu ders koduna ait ders varmı kontrol eder.
            if (mysqli_num_rows($sorgu1)>0){
                    //$sorgu1 den eğer bir satır döner ise alttaki mesaj ekrana basılır
                $message ='Aynı ders koduyla bu programa ait bir ders zaten var.';
               
            }
            else{


                $program = $_POST['bolumler']+0;
                $TSid = $_POST['ogretimGorevlileri']+0;
                $Lname = trim($_POST['Lname']);
                $Lcode = $_POST['Lcode'];


                $stmt="INSERT INTO lectures (Lcode, Lname,TSid, Pid) values ('$Lcode','$Lname','$TSid','$program')";
                // lectures tablosunun insert komutu 
                if(mysqli_query($con,$stmt))    //sorgudan satır döner ise alttaki mesaj bastırılır
                {   
                    $message = 'Ders başarıyla eklenmiştir.' ;
                }
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="addLecture.css" rel="stylesheet" type="text/css">
    <title>Document</title>
</head>
<body>

    
    <form action="" method="POST">
        <h1>DERS EKLEME FORMU</h1>
        <label>Bölümler : </label>


<?php
        $sorguPrograms = 'SELECT * FROM programs';          //Veritabanında ki programs tablosundaki veriler select etiketinin içinde listelendi
        
        $sonucPrograms = mysqli_query($con,$sorguPrograms);

        if($sonucPrograms){
            echo '<select name="bolumler">';
            while($read = mysqli_fetch_assoc($sonucPrograms)){
                echo '<option value="'.$read['Pid'].'">'.$read['Pname']."</option>";        //value olara Pid atandı çünkü Lectures insert edebilmemiz
            }                                                                               //için Pid lazım


            echo '</select>';
        }

        echo '<br><br><br>';
        echo "<label>Öğretmenler : </label>";
        $sorgu = 'SELECT * FROM `teachingstafs` WHERE TSid<>1 ';   //teachingstafs tablosu select etiketinin içine listelendi İD 1 hariç

        $sonuc = mysqli_query($con,$sorgu);

        if($sonuc){
            echo '<select name="ogretimGorevlileri">';
            while($read = mysqli_fetch_assoc($sonuc)){
                echo '<option value="'.$read['TSid'].'">'.$read['TSname'],' ',$read['TSsurname']."</option>";
            }                                       //Value TSid olarak aynı şekilde Lectures kaydı için gerekli 


            echo '</select>';
        }


?>
        <br>

        <br>
        <label>Ders Adı : </label>
        <input type="text" name="Lname">
        <br>

        <br>
        <label>Ders Kodu : </label>

        <input type="text" name="Lcode">
        <br>

        <br>
        <input type="submit" name="addLecture" value="KAYIT ET">
        <a href="home.php">ANA SAYFA</a>

        <label><?php echo '<br>'.$message ;   ?></label>

    
    </form>
</body>
</html>


