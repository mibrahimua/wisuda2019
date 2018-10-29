<html>
<title>Form Upload</title>
<body>
<form enctype="multipart/form-data" onSubmit="return validateForm()" method="POST" action="hasil_upload.php">
File yang di upload : <input type="file" id="fupload" name="fupload"><br>
Deskripsi File : <br>
<textarea name="deskripsi" rows="8" cols="40"></textarea><br>
<input type=submit value=Upload>
</form>

<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }
 
        if(!hasExtension('fupload', ['.pdf'])){
            alert("Hanya PDF yang diijinkan.");
            return false;
        }
    }
</script>