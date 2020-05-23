<?php

session_start();
include 'ayar.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['TSid']!=1) {            //bu alana dışardan ulaşılamaması için ve id'si 1 olmayan kişi dışında giriş yapılamaz
	header('Location: index.html');
	exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
        
a,
input[type=submit] {
	box-shadow: 0px 10px 14px -7px #276873;
	background:linear-gradient(to bottom, #5e9bfe 5%, #408c99 100%);
	background-color:#5e9bfe;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:20px;
	font-weight:bold;
	padding:13px 32px;
	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
a:hover,
input[type=submit]:hover {
	background:linear-gradient(to bottom, #408c99 5%, #5e9bfe 100%);
	background-color:#408c99;
}
a:active,
input[type=submit]:active {
	position:relative;
	top:1px;
}



label{
    display: block;
	font: 13px Arial, Helvetica, sans-serif;
	color: #888;
	margin-bottom: 15px;
}
	.div1{
    width:800px;
	padding:30px;
	margin:40px auto;
	background: #FFF;
	border-radius: 10px;
	-webkit-border-radius:10px;
	-moz-border-radius: 10px;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
    
}
.div2{
    width:600px;
	padding:30px;
	margin:40px auto;
	background: #FFF;
	border-radius: 10px;
	-webkit-border-radius:10px;
	-moz-border-radius: 10px;
	box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
	-webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.13);
    
}

input[type="text"] {
	display: block;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	width: 100%;
	padding: 8px;
	border-radius: 6px;
	-webkit-border-radius:6px;
	-moz-border-radius:6px;
	border: 2px solid #fff;
	box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-moz-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
	-webkit-box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.33);
}
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
    
        h1{
	background: #2A88AD;
	padding: 20px 30px 15px 30px;
	margin: -30px -30px 30px -30px;
	border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	color: #fff;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.12);
	font: normal 30px 'Bitter', serif;
	-moz-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	-webkit-box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	box-shadow: inset 0px 2px 2px 0px rgba(255, 255, 255, 0.17);
	border: 1px solid #257C9E;
}
        
    </style>
</head>
<body>
<div class = "div1">
    <h1>Sınavlar</h1>
<div class = "div2">
    <form action = "" method="POST">
        <label> AD : </label>
        <input name = "search" type = "text" >
        <input name = "searchbtn" value = "ARA" type = "submit"> 
        <a href = "home.php">ANA SAYFA </a>
        
<?php
				
     if (isset($_POST['searchbtn'])){
    
        $sorgu = mysqli_query($con,'SELECT exams.Eid,lectures.Lid,lectures.Lcode,lectures.Lname,lectures.Pid,programs.Pname,examtypes.type,teachingstafs.TSname,teachingstafs.TSsurname FROM 
        ((((lectures LEFT JOIN exams ON lectures.Lid = exams.Lid)INNER JOIN programs on lectures.Pid=programs.Pid)
        INNER JOIN examtypes on exams.ETypeid=examtypes.Etypeid)
        INNER JOIN teachingstafs on lectures.TSid=teachingstafs.TSid) WHERE exams.Eid is not null and lectures.Lname LIKE"'.$_POST['search'].'%"');

        if(mysqli_num_rows($sorgu)>0){
            echo '
            <table>
                <tr>
                    <td>Ad</td>
                    <td>Soyad</td>
                    <td>Ders Ad</td>
                    <td>Ders Kod</td>
                    <td>Bölüm Ad</td>
                    <td>Sınav Türü</td>
                </tr>
            ';
            while($read=mysqli_fetch_array($sorgu)){
                
            echo'  <tr>';
            echo '<td>'.$read['TSname'].'</td>';
            echo '<td>'.$read['TSsurname'].'</td>';
            echo '<td>'.$read['Lname'].'</td>';
            echo '<td>'.$read['Lcode'].'</td>';
            echo '<td>'.$read['Pname'].'</td>';
            echo '<td>'.$read['type'].'</td>';
            echo '</tr>';

            }
            echo '</table>';
        }
        else {
            echo 'Aradığınız Derse ait sınav bulunamadı. ';
        }
        
 }
?>
</form>
</div>
</div>

</body>
</html>