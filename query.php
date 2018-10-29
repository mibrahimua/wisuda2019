<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1.css">
   <meta charset="UTF-8">
	<title>Korpus Putusan PN, PT, dan MA</title>
<body>
	<?php
include 'menu.php';

        ?>
<form enctype="multipart/form-data" method="POST" action="hasilquery.php">
Keyword : <br>
<input type="text" autofocus name="katakunci"><br>
<input type=submit class="tombol" value = "Cek Kata">
</form>