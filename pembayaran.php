<?php
session_start();
include 'koneksi.php'; 

//jika tidak ada session pelanggan dalam arti belum login
if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"]))
{
    echo "<script>alert('Silahkan Login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

//mendapatkan id pembelian dari url
$idpem =$_GET["id"];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian= '$idpem'");
$detpem = $ambil->fetch_assoc();

//dapatkan id pelanggan yang beli
$id_pelanggan_beli = $detpem["id_pelanggan"];
//mendapatkan id pelanggan yang login
$id_pelanggan_login = $_SESSION["pelanggan"]["id_pelanggan"];

if($id_pelanggan_login !==$id_pelanggan_beli)
{
    echo "<script>alert('Jangan Nakal');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();

} 
?>
<html>
<head>
    <title>Pembayaran</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php'; ?>

    <div class="container">
        <h2>Konfirmasi Pemabayaran</h2>
        <p>Kirim Bukti Pembayaran Anda di SIni</p>
        <div class="alert alert-info">Total Tagihan Anda <strong>Rp. <?php echo number_format($detpem["total_pembelian"]); ?></strong></div>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Penyetor</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="form-group">
                <label>Bank</label>
                <input type="text" class="form-control" name="bank">
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" class="form-control" name="jumlah" min="1">
            </div>
            <div class="form-group">
                <label>Foto Bukti</label>
                <input type="file" class="form-control" name="bukti">
                <p class="text-danger">Foto Bukti Harus JPG maksimal 2MB</p>
            </div>
            <button class="btn btn-primary" name="kirim">Kirim</button>
        </form>
    </div>
<?php 
//jk tombol kirim ditekn
if (isset($_POST["kirim"]))
{
    //upload foto bukti
    $namabukti = $_FILES["bukti"]["name"];
    $lokasibukti = $_FILES["bukti"]["tmp_name"];
   $namafiks =date("YmdHis").$namabukti;
    move_uploaded_file($lokasibukti,"bukti_pembayaran/$namafiks");
   
   $nama = $_POST["nama"];
   $bank = $_POST["bank"];
   $jumlah = $_POST["jumlah"];
   $tanggal = date("Y-m-d");
    //simpan pembayaran ke database dan simpan foto ke folder
    $koneksi->query("INSERT INTO pembayaran(id_pembelian,nama,bank,jumlah,tanggal,bukti)
    VALUES ('$idpem','$nama','$bank','$jumlah','$tanggal','$namafiks')");

    //update data pembeliannya dari pending menjadi sudah kirim pembayaran
    $koneksi->query("UPDATE pembelian SET status_pembelian='Sudah Kirim Pembayaran'
    WHERE id_pembelian='$idpem'");
    echo "<script>alert('Terimakasih Sudah Mengirimkan Bukti Pembayaran');</script>";
    echo "<script>location='riwayat.php';</script>";
exit();

}

?>

</body>

</html>


<?php 
include 'footer.php';
?>