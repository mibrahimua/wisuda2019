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
//hitung index
$query = "TRUNCATE TABLE tbvektor" ;
mysqli_query($koneksi, $query);
//ambil setiap DocId dalam tbindex
	//hitung panjang vektor untuk setiap DocId tersebut
	//simpan ke dalam tabel tbvektor
$query = "SELECT DISTINCT DocId FROM tbindex";
	$resDocId = mysqli_query($koneksi, $query);
	
	$num_rows = mysqli_num_rows($resDocId);
	print("Terdapat " . $num_rows . " dokumen yang dihitung panjang vektornya. <br />");
	
	while($rowDocId = mysqli_fetch_array($resDocId)) {
		$docId = $rowDocId['DocId'];
		
		$query = "SELECT Bobot FROM tbindex WHERE DocId = '$docId'";
		$resVektor = mysqli_query($koneksi, $query);
		
		//jumlahkan semua bobot kuadrat 
		$panjangVektor = 0;		
		while($rowVektor = mysqli_fetch_array($resVektor)) {
			$panjangVektor = $panjangVektor + $rowVektor['Bobot']  *  $rowVektor['Bobot'];	
		}
		
		//hitung akarnya		
		$panjangVektor = sqrt($panjangVektor);
		
		//masukkan ke dalam tbvektor
		$query = "INSERT INTO tbvektor (DocId, Panjang) VALUES ('$docId', $panjangVektor)";		
		$resInsertVektor = mysqli_query($koneksi, $query);	
	} //end while $rowDocId

?>