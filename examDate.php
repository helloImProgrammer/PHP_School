<?php
include 'ayar.php';

$message = "";


$sorgu1 = mysqli_query($con,"SELECT * FROM examsdate");
while($read = mysqli_fetch_assoc($sorgu1)){
    $active = $read['exam_acitve_date'];
    $startDate = $read['exam_start_date'];
    $finishDate = $read['exam_finish_date'];

}

if (isset($_POST['submit']))
{
        if(!empty($_POST['ExamDateStart']) && !empty($_POST['ExamDateFinish'])){        // inputların boş olup olmadığını kontrol eder

            if(strtotime(date("Y-m-d"))<=strtotime($_POST['ExamDateFinish'])){  //sınav bitiş tarihi geçmişte seçilmemiş ise 

                if(strtotime($_POST['ExamDateFinish'])>=strtotime($_POST['ExamDateStart'])){    //sınav kayıt bitiş tarihi başlangıç tarihinden büyük mü diye kontorl eder

                    $del = mysqli_query($con,"DELETE FROM examsdate") ; 
                    $start_date = date("Y-m-d",strtotime($_POST["ExamDateStart"])); //inputlardaki değerler alındı
                    $finish_date = date("Y-m-d",strtotime($_POST["ExamDateFinish"]));
                    $date_add = mysqli_query($con ,"INSERT INTO examsdate(exam_start_date,exam_finish_date) VALUES ('".$start_date."','".$finish_date."')");
                                //examsdate tablosuna kayıt edildi sınav kayıt default aktif olarak ayarlanmıştır
                    if($date_add){
                        $delExams = mysqli_query($con,"DELETE FROM exams");
                        if($delExams){
                            $message = "Sınav tarih aralığı oluşturuldu.\nSınav Kayıt dönemi varsayılan olarak AKTİFTİR pasif edebilirsiniz.";
                            header("Refresh:2; url='examDate.php'");
                        }else{
                            $message ="Sınav tarih aralığı OLUŞTURULAMADI.";
                        }
                }
                else{
                    $message = "Sınav tarih aralığı OLUŞTURULAMADI.";
                }
            }
            else{
                $message = "Bitiş Tarihi Başlangıç Tarihinden Büyük Olmalı";    //eğer sınav kayıt bitiş tarihi başlangıç tarihinden küçük
            }                   //seçilmiş ise mesaj bastırılır

        }
        else{
            $message ="Geçmiş Tarih Ayarlanamaz";   //şuan ki tarihten önceki bir tarih aralığı seçildi ise
        }  
    }
    else{                           //inputlar boş ise
    $message = "Boş bırakmadığınızdan emin olun.";
    }
}
        
if(isset($_POST['activeExamDate'])){    //sınavı kayıt işlemlerini aktif eder
    $result = 1;
    header("Refresh:2; url='examDate.php'");
    $message = "Sınav Kayıt işlemleri Aktif edilmiştir";
    $upd = mysqli_query($con,"UPDATE examsdate SET exam_acitve_date =".$result.""); 
}
if(isset($_POST['passiveExamDate'])){       //sınavı kayıt işlemlerini pasif eder
    $result = 0;
    $upd = mysqli_query($con,"UPDATE examsdate SET exam_acitve_date =".$result."");
    $message = "Sınav Kayıt işlemleri pasif edilmiştir";
    header("Refresh:2; url='examDate.php'");
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="addLecture.css" rel="stylesheet" type="text/css">
</head>
<body>

<form action = "" method = "post">
<h1>Sınav Kayıt Tarih Aralığı</h1>
<pre>
    <label>Açılış Tarihi</label>
    <input type = "date" name = "ExamDateStart">
    <label>Kapanış Tarihi</label>
    <input type = "date" name = "ExamDateFinish">
<?php if(strtotime(date("Y-m-d"))<=strtotime($finishDate)){if($active == 0) {echo '<input type = "submit" name = "activeExamDate" value="AktifEt">';}
else{echo'<input type = "submit" name = "passiveExamDate" value="PasifEt">';}}?>
    <input type = "submit" name = "submit" value="Oluştur">   <a href = "home.php">ANA SAYFA</a>
    <label><?php echo $message ;?></label>
</pre>
</form>


</body>
</html>