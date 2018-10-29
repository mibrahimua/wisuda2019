<?php
include "koneksi.php";



$judul_putusan = $_POST['judul_putusan'];
$deskripsi_putusan = $_POST['deskripsi_putusan'];
$asal_putusan = $_POST['asal_putusan'];

$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];


$target_dir = "D:/Data Sementara/";
$target_file = $target_dir . $fileName;

if (move_uploaded_file($tmpName, $target_file)) {
    	$query = "INSERT INTO data_korpus (judul_putusan, deskripsi_putusan, jenis_putusan, lokasi_file) VALUES ('$judul_putusan', '$deskripsi_putusan', '$asal_putusan', '$fileName')";
 
		$hasil = mysqli_query($koneksi,$query);
		if($hasil){
		  ?>
		   <script type="text/javascript">alert('Data Tersimpan'); window.location = 'index.php';</script>
		  <?php }else{?>
		   <script type="text/javascript">alert('Ops, Ada Kesalahan'); window.location = 'index.php';</script>
		  <?php }
        
        
    } else {
    	?>
    	 <script type="text/javascript">alert('Ops, Gagal Upload File'); window.location = 'index.php';</script>
    	 <?php
    }



 

?>