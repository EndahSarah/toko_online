<?php session_start(); ?>
<?php 
include 'koneksi.php';
//menangkap id url
$id_produk = $_GET["id"];

//ambildata query
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail=$ambil->fetch_assoc();


?>


<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<?php include 'menu.php'; ?>
<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="foto_produk/<?php echo $detail["foto_produk"];?>" alt="" class="img-responsive">
            </div>
            <div class="col-md-6">
                <h2><?php echo $detail["nama_produk"];?></h2>
                <h4>Rp. <?php echo number_format($detail["harga_produk"]);?>,00</h4>
                <h5>Stok: <?php echo $detail["stok_produk"]?></h5>
                <form method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" min=1  class="form-control" name="jumlah" max=
                            <?php echo $detail['stok_produk'] ?>>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" name="beli">Beli</button>
                                </div>
                        </div>
                    </div>        
                </form>
                <?php 
                //jk ada tombol beli
                if (isset($_POST['beli']))
                {
                    //dapat jumlah yg diinput
                    $jumlah=$_POST["jumlah"];
                    //masuk keranjang belanja
                    $_SESSION["keranjang"][$id_produk] = $jumlah;
                    echo "<script>alert('Produk Telah Masuk Ke Kranjang Belanja');</script>";
                    echo "<script>location='keranjang.php';</script>";
                }

                ?>
                <p><?php echo $detail["deskripsi_produk"];?></p>
            </div>
        </div>
    </div>
</section>

</html>

<?php 
include 'footer.php';
?>