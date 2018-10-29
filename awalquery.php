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
<form enctype="multipart/form-data" method="POST">
Kata Kunci : <br>
  <input type="text" autofocus name="keyword"><br>
<input type=submit value = "Cek Kata"  class="tombol">

</form>
<?php

include 'querytf2.php';
?>