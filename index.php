<?php
session_start();
//koneksi  ke database
include 'koneksi.php';

?>

<html>
<head>
<title>Ensa Store</title>
<link rel="stylesheet" href="admin/assets/css/bootstrap.css">    
</head>
<body>
<?php include 'menu.php'; ?>
<section class="konten">
<div class="container">
    <h1>Produk Terbaru</h1>
    <div class="row">

        <?php $ambil = $koneksi->query("SELECT * FROM produk");?>
        <?php while($perproduk = $ambil->fetch_assoc()){?>
        <div class="col-md-3">
            <div class="thumbnail">
                <img src="foto_produk/<?php echo $perproduk['foto_produk'];?>" alt="" class="img-thumbnail" >
                <div class="caption">
                    <h3><?php echo $perproduk['nama_produk'];?></h3>
                    <h5>Rp. <?php echo number_format($perproduk['harga_produk']);?>,00</h5>
                    <a href="beli.php?id=<?php echo $perproduk['id_produk'];?> " class="btn btn-success">Beli</a>
                    <a href="detail.php?id=<?php echo $perproduk['id_produk'];?>" class="btn btn-default">Detail</a>
                </div>
            </div>
        </div>
        <?php 
        } 
        ?>
    
    </div>
</div>

</section>
<script src="admin/assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
include 'footer.php';
?>