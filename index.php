
<?php
include "koneksi.php";

function tanggal_indo($tanggal, $cetak_hari = true)
    {
    $hari = array ( 1 =>    'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
                'Minggu'
            );
            
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    
    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
    }
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

    <body>
        <?php
include 'menu.php';

        ?>
        <form id="upload" action="hasil_upload.php?upload=upload" method="POST" enctype="multipart/form-data">
            <table>
                    <td>
                        Deskripsi Putusan: 
                    </td>
                    <td>
                        <textarea name="deskripsi" cols="30" rows="5" placeholder="Deskripsi"></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <input type="file" id="fupload" required="" name="fupload">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Upload" class="tombol">
                    </td>
                </tr>
                   
                
            </table>
            
            
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
        <table id="rowhover" class="isi">
            <tr>`
            <th>
                Nama File
            </th>
            <th>
                Deskripsi Putusan
            </th>
            
            <th>
                Unduhan File
            </th>
            <th>
                Tanggal Upload
            </th>
        </tr>
<?php
            $query = "SELECT nama_file,deskripsi,tgl_upload FROM upload ORDER BY tgl_upload DESC ";
            $sql = mysqli_query($koneksi, $query);
            while ($data = mysqli_fetch_array($sql)) {
                //$target_dir = "https://mibrahimua.000webhostapp.com/konten/";
                $target_dir = "http://wisuda2019.xyz/files/";
                $target_file = $target_dir . $data['nama_file'];
?>
<tr>
                 
                     <td align="center">
                        <?php echo $data['nama_file']; ?>
                    </td>
                    <td align="center">
                        <?php echo $data['deskripsi']; ?>
                    </td>
                    <td align="center">
                        <a href="<?php echo $target_file;?>">Unduh</a>
                    </td>
                    <td align="center">
                        <?php
                        $tgl = explode(" ", $data['tgl_upload']);   
                        $tanggal = tanggal_indo($tgl[0]); 
                        echo $tanggal;
                        ?>
                    </td>
                </tr>
                    <?php
            }
            ?>

        
        </table>
   

