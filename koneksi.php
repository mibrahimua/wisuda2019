<?php
$koneksi = mysqli_connect("localhost","wisudaxy","unisbank2019","wisudaxy_dbstbi")
//$koneksi = mysqli_connect("localhost","root","","dbstbi")
or die ("Error" . mysqli.error($koneksi));

if($koneksi){
}else{
	echo " ra iso konek database bos";
}
?>