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
        <table id="rowhover" class="isi" width="99%">
      <tr>
        <th>
              No
          </th>
          <th>
              Nama File
          </th>
          <th>
              Token
          </th>
          <th>
              Tokenstem
          </th>
      </tr>

<?php
include "koneksi.php";
$nomor=1;
$hasil=$_POST['katakunci'];
//$sql = "SELECT distinct nama_file,token,tokenstem FROM `dokumen` where token like '%$hasil%'";
$sql = "SELECT DISTINCT nama_file,token,tokenstem FROM dokumen WHERE token LIKE '%$hasil%'";


//echo $sql;
$result = mysqli_query($koneksi,$sql);
if($result){
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    ?>
  

  
    <?php
    while($row = mysqli_fetch_assoc($result)) {
        //echo "Nama file: " . $row["nama_file"]. " - Token: " . $row["token"]. " " . $row["tokenstem"]. "<br>";

        ?>
        <tr>
            <td align="center">
               <?php echo $nomor++; ?>
            </td> 
            <td align="center">
                <?php echo $row['nama_file']; ?>
            </td>
            <td align="center">
                <?php echo $row['token']; ?>
            </td>
            <td align="center">
                <?php echo $row['tokenstem']; ?>
            </td>
        </tr>
        <?php
    }
    
    } else {
      ?>
      <td colspan="4">
                <?php echo "0 results"; ?>
            </td>
    
    </table>
    <?php
}
}else{
    echo "tidak ada data";
}

///

?>
</body>
</html>