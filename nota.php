<?php
session_start();
include 'koneksi.php';

?>

<html>

<head>
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<?php include 'menu.php'; ?>
<section class="konten">
    <div class="container">
        <!-- nota kopi dari nota detail admin -->
        <h2>Detail Pembelian</h2>

<?php 
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan
ON pembelian.id_pelanggan=pelanggan.id_pelanggan
where pembelian.id_pembelian='$_GET[id]'" );
$detail = $ambil->fetch_assoc(); 
?>
<!--jika pelanggan yang beli tidak sama dengan yang login maka dilarikan
ke riwayat.php karena dia tidak berhak melihat nota orla-->
<!--pelanggan yang beli harus pelanggan yang login-->
<?php
//mendapatkan id_pelanggan yang beli
$idpelangganygbeli = $detail["id_pelanggan"];

//mendapatkan id_pelanggan yang beli
$idpelangganyglogin = $_SESSION["pelanggan"]["id_pelanggan"];
if ($idpelangganygbeli!==$idpelangganyglogin)
{
    echo "<script>('Jangan Nakal);</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>
<div class="row">
    <div class="col-md-4">
        <h3>Pembelian</h3>
        <strong> No. Pembelian : <?php echo $detail['id_pembelian'];?></strong><br>
        Tanggal : <?php echo date("d F Y",strtotime($detail['tanggal_pembelian'])); ?> <br>
        Total : Rp. <?php echo number_format($detail['total_pembelian']); ?>,00

       
    </div>
    <div class="col-md-4">
        <h3>Pelanggan</h3>
        <strong>NAMA : <?php echo $detail['nama_pelanggan']; ?></strong><br>
        <p>
            No.Telp : <?php echo $detail['telephon_pelanggan']; ?> <br>
            E-mail : <?php echo $detail['email_pelanggan']; ?>
        </p>

    </div>
    <div class="col-md-4">
    <h3>Pengiriman</h3>
    <strong>ALAMAT : <?php echo $detail['tipe'];?><?php echo $detail['distrik'];?><?php echo $detail['provinsi'];?> <?php echo $detail['kodepos'];?></strong><br>
    Ongkos Kirim : Rp. <?php echo number_format($detail['ongkir']);?>,00<br>
    Ekspedisi : <?php echo $detail['ekspedisi'];?> <?php echo $detail['paket'];?> <?php echo $detail['estimasi'];?><br>
    Alamat Pengiriman : <?php echo $detail['alamat_pengiriman'];?>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Berat</th>
            <th>Jumlah</th>
            <th>Subberat</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor=1; 
       $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'");
       ?>
         <?php while($pecah=$ambil->fetch_assoc()){ ?> 
       <tr>
           <th><?php echo $nomor; ?></th>
           <th><?php echo $pecah['nama']; ?></th>
           <th>Rp. <?php echo number_format($pecah['harga']); ?>,00</th>
           <th><?php echo $pecah['berat']; ?> Gr. </th>
           <th><?php echo $pecah['jumlah']; ?></th>
           <th><?php echo $pecah['subberat']; ?> Gr. </th>
           <th>Rp. <?php echo number_format($pecah['subharga']) ; ?>,00</th>
       </tr>
        <?php $nomor++; ?>    
        <?php } ?>
    </tbody>
</table>
            <div class="row">
                <div class="col-md-7">
                    <div class="alert alert-info">
                        <p>
                            Silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?>,00 <br>
                            ke <br>
                            <strong>BANK BRI 1010283939 ENDAH SARAH WANTY </strong>
                        </p>
                    </div>
                </div>

            </div>


    </div>
</section>
</body>
</html>


<?php 
include 'footer.php';
?>