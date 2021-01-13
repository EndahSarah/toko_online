<?php 
session_start();
include 'koneksi.php';

$id_pembelian=$_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembayaran
LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian
WHERE pembelian.id_pembelian='$id_pembelian'");
$detbay = $ambil->fetch_assoc();
//echo "<pre>";
//print_r($detbay);
//echo "</pre>";

//validasi 1 jika belum ada data pembayaran
if(empty($detbay))
{
    echo "<script>alert('Belum Ada Data Pembayaran')</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}

//validasi 2 data pelanggan yg bayar tidak sesuai dengan yang login

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
if ($_SESSION["pelanggan"]["id_pelanggan"]!==$detbay["id_pelanggan"])
{
    echo "<script>alert('Anda Tidak Berhak Melihat Pembayran Orang Lain')</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lihat Pembayaran</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
        <?php include 'menu.php'; ?>

        <div class="container">
            <h3>Lihat Pembayaran</h3>
            <div class="col-md-6">
                <table class="table">
                  <tr>
                      <th>Nama</th>
                      <td><?php echo $detbay["nama"] ?></td>
                  </tr>  
                  <tr>
                      <th>Bank</th>
                      <td><?php echo $detbay["bank"] ?></td>
                  </tr>  
                  <tr>
                      <th>Tanggal</th>
                      <td><?php echo $detbay["tanggal"] ?></td>
                  </tr>  
                  <tr>
                      <th>Jumlah</th>
                      <td>Rp.<?php echo number_format($detbay["jumlah"] ) ?> </td>
                  </tr>  
                   
                </table>
            </div>
            <div class="col-md-6">
                <img src="bukti_pembayaran/<?php echo $detbay["bukti"]; ?>" alt="" class="img-responsive">
            </div>
        </div>
</body>
</html>

<?php 
include 'footer.php';
?>