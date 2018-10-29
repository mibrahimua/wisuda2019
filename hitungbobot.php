<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1.css">
   <meta charset="UTF-8">
	<title>Korpus Putusan PN, PT, dan MA</title>
</head>
<body>
<?php
include 'menu.php';

        ?>
</body>
</html>
<?php
include "koneksi.php";
set_time_limit(0);
/*
$host='localhost';
$user='root';
$pass='';
$database='dbstbi';

$conn=mysqli_connect($host,$user,$pass);
mysqli_select_db($database);
*/
//hitung index

$query = "TRUNCATE TABLE tbindex";
mysqli_query($koneksi, $query);
$query = "INSERT INTO tbindex(Term, DocId, Count) SELECT token,nama_file,count(dokid) FROM dokumen group by nama_file,token";
$resn = mysqli_query($koneksi, $query);
	//$n = mysqli_num_rows($resn);
	

//berapa jumlah DocId total?, n
	$query = "SELECT DISTINCT DocId FROM tbindex";
	$resn = mysqli_query($koneksi, $query);
	$n = mysqli_num_rows($resn);
	
	//ambil setiap record dalam tabel tbindex
	//hitung bobot untuk setiap Term dalam setiap DocId
	$query = "SELECT Term,Count,Id FROM tbindex ORDER BY Id";
	$resBobot = mysqli_query($koneksi, $query);
	$num_rows = mysqli_num_rows($resBobot);
	print("Terdapat " . $num_rows . " Term yang diberikan bobot. <br />");

	while($rowbobot = mysqli_fetch_array($resBobot)) {
		//$w = tf * log (n/N)
		$term = $rowbobot['Term'];		
		$tf = $rowbobot['Count'];
		$id = $rowbobot['Id'];
		
		//berapa jumlah dokumen yang mengandung term tersebut?, N
		$query = "SELECT Count(Term) as N FROM tbindex WHERE Term = '$term'";
		$resNTerm = mysqli_query($koneksi, $query);
		$rowNTerm = mysqli_fetch_array($resNTerm);
		$NTerm = $rowNTerm['N'];
		
		$w = $tf * log($n/$NTerm);
		
		
		//update bobot dari term tersebut
		$query = "UPDATE tbindex SET Bobot = $w WHERE Id = $id";
		$resUpdateBobot = mysqli_query($koneksi, $query);		
  	} //end while $rowbobot


?>