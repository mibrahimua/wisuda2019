
<?php
////
function hitungsim($keyword) {
	//ambil jumlah total dokumen yang telah diindex (tbindex atau tbvektor), n
include 'koneksi.php';

//echo "hitung sim";

	$query = "SELECT Count(*) as n FROM tbvektor";
	$resn = mysqli_query($koneksi , $query);
	$rown = mysqli_fetch_array($resn);	
	$n = $rown['n'];
	//echo "hasil tbvektor";
	
	//print_r($rown);

	//echo $keyword;
	//terapkan preprocessing terhadap $query
	$aquery = explode(" ", $keyword);
	//print_r($aquery);
	//hitung panjang vektor query
	$panjangQuery = 0;
	$aBobotQuery = array();
	
	for ($i=0; $i<count($aquery); $i++) {
		//hitung bobot untuk term ke-i pada query, log(n/N);
		//hitung jumlah dokumen yang mengandung term tersebut
		$query = "SELECT Count(*) as N from tbindex WHERE Term like '%$aquery[$i]%'";
		$resNTerm = mysqli_query($koneksi, $query);
//		echo "query >SELECT Count(*) as N from tbindex WHERE Term like '%$aquery[$i]%'";
		$rowNTerm = mysqli_fetch_array($resNTerm);	
		$NTerm = $rowNTerm['N'] ;
		
		$idf = @log($n/$NTerm);
		
		//simpan di array		
		$aBobotQuery[] = $idf;
		
		$panjangQuery = $panjangQuery + $idf * $idf;		
	}
	
	$panjangQuery = sqrt($panjangQuery);
	$jumlahmirip = 0;
	
	//ambil setiap term dari DocId, bandingkan dengan Query
	$query = "SELECT * FROM tbvektor ORDER BY DocId";
	$resDocId = mysqli_query($koneksi ,$query);
	while ($rowDocId = mysqli_fetch_array($resDocId)) {
		$dotproduct = 0;
			
		$docId = $rowDocId['DocId'];
		$panjangDocId = $rowDocId['Panjang'];
		$query = "SELECT * FROM tbindex WHERE DocId = '$docId'";
		//echo $docId;
		$resTerm = mysqli_query($koneksi, $query);
	//	echo "query ->SELECT * FROM tbindex WHERE DocId = '$docId'".'<br>';
		
		while ($rowTerm = mysqli_fetch_array($resTerm)) {
			for ($i=0; $i<count($aquery); $i++) {
				//jika term sama
				//echo "1-->".$rowTerm['Term'];
			//	echo "2-->".	$aquery[$i].'<br>';
				//echo $rowTerm['Term']." == ".$aquery[$i].'<br>';
				//echo $rowTerm['Bobot']." ini Bobot".'<br>';	
				//echo count($aquery)."ini aquery.'<br>'";
				if ($rowTerm['Term'] == $aquery[$i]) {
					$dotproduct = $dotproduct + $rowTerm['Bobot'] * $aBobotQuery[$i];

					if ($dotproduct != 0) {
			$sim = $dotproduct / ($panjangQuery * $panjangDocId);	
			//echo "insert >>INSERT INTO tbcache (Query, DocId, Value) VALUES ('$query', '$docId', $sim)";
			//simpan kemiripan > 0  ke dalam tbcache
			$query = "INSERT INTO tbcache (Query, DocId, Value) VALUES ('$aquery[$i]', '$docId', $sim)";
			
			$resInsertCache = mysqli_query($koneksi ,$query) or die ('Unable to execute query. '. mysqli_error($koneksi));
			echo "Tidak menemukan kata '".$aquery[$i]."', Simpan nama file '".$docId ."' ke tabel tbcache <br>";
			$jumlahmirip++;
		}
		//			echo "hasil =".$dotproduct.'<br>';
			//		echo "1-->".$rowTerm['Term'];
			//	echo "2-->".	$aquery[$i].'<br>';
					
				} //end if
					else
					{
						//echo "Maaf kata tersebut memiliki nilai bobot 0, silahkan cari kata yang lain";
					}
			} //end for $i		
		} //end while ($rowTerm)
		 
			
	if ($jumlahmirip == 0) {
		$query = "INSERT INTO tbcache (Query, DocId, Value) VALUES ('$query', 0, 0)";
		$resInsertCache = mysqli_query($koneksi, $query);
	}	
	} //end while $rowDocId
	
		
} //end hitungSim()





	////
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1.css">
   <meta charset="UTF-8">
</head>
<body>
<?php

if(isset($_POST['keyword'])){


$keyword=$_POST['keyword'];
$query = "SELECT *  FROM tbcache WHERE Query = '$keyword' ORDER BY Value DESC";
$resCache = mysqli_query($koneksi ,$query);
	$num_rows = mysqli_num_rows($resCache);
	//echo $num_rows;
	if ($num_rows >0) {

		//tampilkan semua berita yang telah terurut
		while ($rowCache = mysqli_fetch_array($resCache)) {
			$docId = $rowCache['DocId'];
			$sim = $rowCache['Value'];
					
				//ambil berita dari tabel tbberita, tampilkan
				//echo ">>>SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'";
				$query = "SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'";
				$resBerita = mysqli_query($koneksi, $query);
				$rowBerita = mysqli_fetch_array($resBerita);
					
				$judul = $rowBerita['nama_file'];
				$berita = $rowBerita['deskripsi'];
					echo "<br>";
				print($docId . ". (" . $sim . ") <font color=blue><b><a href=" . $judul . "> </b></font><br />");
				print($berita . "<hr /></a>"); 		
			
		}//end while (rowCache = mysqli_fetch_array($resCache))
	}else
		{
		hitungsim($keyword);
		
		//pasti telah ada dalam tbcache	
		$query = "SELECT *  FROM tbcache WHERE Query = '$keyword' ORDER BY Value DESC";	
		$resCache = mysqli_query($koneksi, $query);
		$num_rows = mysqli_num_rows($resCache);
		//echo $num_rows;
		if ($num_rows >0) {
		while ($rowCache = mysqli_fetch_array($resCache)) {
			$docId = $rowCache['DocId'];
			$sim = $rowCache['Value'];
					
				//ambil berita dari tabel tbberita, tampilkan
				$query = "SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'";
				$resBerita = mysqli_query($koneksi, $query);
				$rowBerita = mysqli_fetch_array($resBerita);
					
				$judul = $rowBerita['nama_file'];
				$berita = $rowBerita['deskripsi'];
					echo "<br>";
				print($docId . ". (" . $sim . ") <font color=blue><b><a href=" . $judul . "> </b></font><br />");
				print($berita . "<hr /></a>");
		
		} //end while
	}else{
		echo "<br> Maaf kata '".$keyword."' memiliki nilai bobot 0, silahkan cari kata yang lain.";
		}
	}
}else{
	echo "</br>"."Selamat Datang di Pengelolaan Dokumen Indexing Subsystem";
}
?>
</body>
</html>