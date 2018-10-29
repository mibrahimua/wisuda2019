<html>
<title>Form Empty</title>
<body align="center" style="background-color: orange">
<center><img src="img3.png" style="width:900px;height:150px;">
<br>
<br>
<h2>Halaman Pengosongan</h2>
<?php
$host = 'localhost';
  $user = 'root';      
  $password = '';      
  $database = 'dbstbi';  
    
  $konek_db = mysql_connect($host, $user, $password);    
  $find_db = mysql_select_db($database) ;

$query1 = "DELETE FROM `dokumen` WHERE 1";
$query2= "DELETE FROM `upload` WHERE 1";
 
$hasil1 = mysql_query ($query1);
$hasil2 = mysql_query ($query2);

$files = glob('files/*.pdf'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}
echo "Data telah dihapus.";
?>
<br>
<a> Kembali ke tabel ? </a> <br>
<br>
<a href="index.php"><input type="button" value="Ya"/></a> <a href="empty.php"><input type="button" value="Tidak"/></a>
</body></center>
</html>
