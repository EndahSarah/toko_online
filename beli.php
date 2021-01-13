<?php 
session_start();
//menangkap id produk dari url
$id_produk = $_GET['id'];

//jk ada produk dikeranjang, maka +1 
if(isset($_SESSION['keranjang'][$id_produk]))
{
    $_SESSION['keranjang'][$id_produk]+=1;
}

//selain itu(belm ada dikeranjang), maka produk dianggap beli 1
else
{
    $_SESSION['keranjang'][$id_produk] =1;
}

//larikan ke halaman keranjang

echo "<script>alert('Produk Telah Masuk Ke Keranjang Belanja');</script>";
echo "<script>location='keranjang.php';</script>";

?>
