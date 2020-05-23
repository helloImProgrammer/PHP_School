<?php
include 'ayar.php';

$message = "";


if(isset($_POST['ForgotPassBtn'])){ //btn kontrolü

    if(!empty($_POST['ForgotPass1']) && !empty($_POST['ForgotPassSecurityWord']) && !empty($_POST['ForgotPassEmail'])){ // inputların boş olup
                                                                                                        //olmadığını kontrol eder
        $sorgu = mysqli_query($con,"SELECT * FROM teachingstafs WHERE email='".$_POST['ForgotPassEmail']."'");
                                                    //sorguda email bilgisini verip kullanıcının TSid ve Security_word billgisini alıyoruz
        if(mysqli_num_rows($sorgu)>0){
            
            while($read = mysqli_fetch_assoc($sorgu)){

                $TSid= $read['TSid'];

                $security_word = $read['TS_security_word'];
                
            }
        

        $email = trim($_POST['ForgotPassEmail']);
        $securityWord = trim($_POST['ForgotPassSecurityWord']);
        $pass = $_POST['ForgotPass1'];

        if(password_verify($securityWord,$security_word)){

            if($pass == $_POST['ForgotPass2']){
                $pass = password_hash($_POST['ForgotPass1'],PASSWORD_DEFAULT);
                $upd = mysqli_query($con,"UPDATE teachingstafs SET password ='".$pass."' WHERE TSid =".$TSid);

                if($upd){

                    $message = "Şifreniz başarılı bir şekilde yenilendi.";
                }

                else{

                    $message = "Şifre yenileme işleminiz başarısız.";

                }

            }
            else{

                $message = "Şifreleriniz eşleşmiyor lütfen aynı olduğundan emin olun.";
            }

        }
        else{

            $message = "Güvenlik Kelimeniz Eşleşmedi.";
        }

    }else{

        $message = "Böyle bir mail adresi bulunamadı.";
        
    }
}else{
        
        $message = "Boş Bırakılamaz.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Yenile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div  class="login">
    <form action = "" method = "POST">
    <label for="email">
					<i class="fas fa-mail-bulk"></i>
				</label>
        <input type = "text" placeholder = "E-posta adresiniz" name = "ForgotPassEmail">
        <label for="password">
					<i class="fas fa-lock"></i>
				</label>
        <input type = "password" placeholder = "Güvenlik Kelimeniz" name = "ForgotPassSecurityWord">
        <label for="password">
					<i class="fas fa-lock"></i>
				</label>
        <input type = "password" placeholder = "Şifre" name = "ForgotPass1">
        <label for="password">
					<i class="fas fa-lock"></i>
				</label>
        <input type = "password" placeholder = "Şifre Tekrar" name = "ForgotPass2">


        <input type = "submit" name = "ForgotPassBtn" value = "Yenile">


        <strong><?php echo $message ; ?></strong>



        

        
    </form>
    <h2><a href= "index.html">Giriş Yap</a></h2><br>
</div>
</body>
</html>