<?php
//membuat koneksi ke database
include "koneksi.php";
include 'menu.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1.css">
   <meta charset="UTF-8">
   <title>Korpus Putusan PN, PT, dan MA</title>
</head>
<body>
<html>
    <head>
       <h2>HASIL TOKENISASI DAN STEMMING</h2>
        
    </head>
    <body>
        <?php


        ?>
 


<!-- ///////////////////////////// Script untuk membuat tabel///////////////////////////////// -->

 <table id="rowhover" class="isi"> 
<tr>
    <th> Nama File </th>
    <th> Tokenisasi </th>
    <th> Stemming Porter </th>
    <th> Stemming Nazief Adriani</th>
    
</tr>

<?php  
// Perintah untuk menampilkan data
$query="SELECT * FROM dokumen" ;  //menampikan SEMUA

 $sql = mysqli_query($koneksi, $query);

// perintah untuk membaca dan mengambil data dalam bentuk array
while ($data = mysqli_fetch_array ($sql)) {
$id = $data['dokid'];
?>
<tr>
                 
        <td align="center">
            <?php echo $data['nama_file']; ?>
        </td>
        <td align="center">
            <?php echo $data['token']; ?>
        </td>
        <td align="center">
            <?php echo $data['tokenstem']; ?>
        </td>
        <td align="center">
            <?php echo $data['tokenstem2']; ?>
        </td>
 
 <?php       
}

?>

</table>
</body>
</html>