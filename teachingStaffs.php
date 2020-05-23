<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="addLecture.css" rel="stylesheet" type="text/css">
    <style>
        		table {
		  border-collapse: collapse;
		  width: 40%;
		}
 
		th, td {
		  text-align: left;
		  padding: 15px;
		}
		th{
			background-color: #4CAF50;
  			color: white;
		}
 
		tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
    

</head>
<body>
   
        <form action ="" method ="POST">
            <label>Öğretim Görevlisi Ad : </label>
            <input type = "text" name ="TSsearch">
            <input type = "submit" name = "TSsearchBtn" value = "ARA">
            <a href = "home.php">ANA SAYFA</a>

<?php

include 'ayar.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['TSid']!=1) {            //bu alana dışardan ulaşılamaması için ve id'si 1 olmayan kişi dışında giriş yapılamaz
	header('Location: index.html');
	exit;
}



if(isset($_POST['TSsearchBtn'])){


    $sorgu = mysqli_query($con,'SELECT * FROM teachingstafs WHERE TSname like "'.$_POST['TSsearch'].'%" ORDER BY TSname ASC');
   
        if(mysqli_num_rows($sorgu)>0){
            echo '
            <table>
                <tr>
                    <td>Ad</td>
                    <td>Soyad</td>
                    <td>E-mail</td>
                    <td>Dersler</td>
                </tr>
            ';
            
            while($read=mysqli_fetch_array($sorgu)){

            echo '<tr>';
            echo '<td>'.$read['TSname'].'</td>';
            echo '<td>'.$read['TSsurname'].'</td>';
            echo '<td>'.$read['email'].'</td>';
            echo '<td>';
            $sorgu2  =mysqli_query($con,"SELECT * FROM lectures WHERE TSid =".$read['TSid']);
            while($read2 = mysqli_fetch_assoc($sorgu2)){
                echo $read2['Lname']."<br>";
            }
           
            echo '</td></tr>';

            }
            echo '</table>';
        }
    }

    
?>
        </form>
</body>
</html>
