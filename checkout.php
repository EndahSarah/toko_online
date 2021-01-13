<?php
session_start();
error_reporting(0);
include 'koneksi.php';

//jika tidak adad session pelanggan atau belum login maka login.php
if (!isset($_SESSION["pelanggan"]))
{
    echo "<script>alert('Silahkan Login');</script>";
    echo "<script>location='login.php';</script>";    
}
?>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
    <script src="admin/assets/js/jquery.min.js"></script>
</head>
<body>
<?php include 'menu.php'; ?>
<section class="konten">
    <div class="container">
        <h1>Keranjang Belanja</h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subharga</th>
                </tr>
            </thead>
            <tbody>
            <?php $n=1; ?>
            <?php $totalberat = 0; ?>
            <?php $totalbelanja = 0; ?>
            <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) : ?>
            <?php 
            $ambil = $koneksi->query("SELECT * FROM produk 
            WHERE id_produk='$id_produk'");
            $pecah = $ambil->fetch_assoc();
            $subharga = $pecah["harga_produk"]*$jumlah;
            //subberat diperoleh dari berat produk x jumlah
            $subberat = $pecah["berat_produk"] * $jumlah;
            //total berat
            $totalberat+=$subberat;
            

            ?>
                <tr>
                    <td><?php echo $n++;?></td>
                    <td><?php echo $pecah["nama_produk"];?></td>
                    <td>Rp. <?php echo number_format($pecah["harga_produk"]) ;?>,00</td>
                    <td><?php echo $jumlah; ?></td>
                    <td>Rp. <?php echo number_format($subharga);?>,00</td>
                </tr>
            <?php $totalbelanja+=$subharga; ?>    
            <?php endforeach ?>  
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" >Total Belanja</th>
                    <th>Rp. <?php echo number_format($totalbelanja); ?>,00</th>
                </tr>
            </tfoot>
        </table>
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]["nama_pelanggan"]?>" class="form-control">
                        </div>    
                </div>
                <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" readonly value="<?php echo $_SESSION["pelanggan"]["telephon_pelanggan"]?>" class="form-control">
                        </div>    

                </div>
            </div>
            <div class="form-group">
            <label>Alamat Lengkap Pengiriman</label>
            <textarea class="form-control" name="alamat_pengiriman" placeholder="Masukan almat lengkap pengiriman(termasuk kode pos)"></textarea>
            </div>
            <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select class="form-control" name="nama_provinsi" id="">
                                </select>    
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Distrik</label>
                                <select class="form-control" name="nama_distrik" id="">
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ekspedisi</label>
                                <select class="form-control" name="nama_ekspedisi" id="">
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Paket</label>
                                <select class="form-control" name="nama_paket" id="">
                                </select>    
                            </div>
                        </div>
                </div>
                <input type="text" name="total_berat" value="<?php echo $totalberat ;?>">
                <input type="text" name="provinsi" value="">
                <input type="text" name="distrik" value="">
                <input type="text" name="tipe" value="">
                <input type="text" name="kodepos" value="">
                <input type="text" name="ekspedisi" value="">
                <input type="text" name="paket" value="">
                <input type="text" name="ongkir" value="">
                <input type="text" name="estimasi" value="">
            <button class="btn btn-primary" name="checkout">Checkout</button>
        </form>
        <?php 
        if (isset($_POST["checkout"]))
        {
            $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
            $tanggal_pembelian = date("Y-m-d");
            $alamat_pengiriman = $_POST['alamat_pengiriman'];
            $totalberat = $_POST["total_berat"];
            $provinsi = $_POST["provinsi"];
            $distrik = $_POST["distrik"];
            $tipe = $_POST["tipe"];
            $kodepos = $_POST["kodepos"];
            $ekspedisi = $_POST["ekspedisi"];
            $paket = $_POST["paket"];
            $ongkir = $_POST["ongkir"];
            $estimasi = $_POST["estimasi"];
            $total_pembelian = $totalbelanja + $ongkir;

            //menyimpan data ke tabel pembelian 
            $koneksi->query("INSERT INTO pembelian (
            id_pelanggan,tanggal_pembelian,total_pembelian,alamat_pengiriman,totalberat,provinsi,distrik,tipe,
            kodepos,ekspedisi,paket,ongkir,estimasi)
            VALUES ('$id_pelanggan','$tanggal_pembelian',
            '$total_pembelian','$alamat_pengiriman','$totalberat','$provinsi',
            '$distrik','$tipe','$kodepos','$ekspedisi','$paket','$ongkir','$estimasi')"); 
            //mendapatkan id_pembelian barusan
            $id_pembelian_barusan = $koneksi->insert_id;

            foreach ($_SESSION["keranjang"] as $id_produk => $jumlah)
            {
                $ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
                $perproduk = $ambil->fetch_assoc();
                $nama =$perproduk['nama_produk'];
                $harga =$perproduk['harga_produk'];
                $berat =$perproduk['berat_produk'];
                $subberat = $perproduk['berat_produk']*$jumlah;
                $subharga =$perproduk['harga_produk']*$jumlah;
                $koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,jumlah,nama,harga,berat,subberat,subharga)
                    VALUES ('$id_pembelian_barusan', '$id_produk','$jumlah','$nama','$harga','$berat','$subberat','$subharga')");

                //skript update  stok
                   $koneksi->query("UPDATE produk SET stok_produk=stok_produk -$jumlah
                   WHERE id_produk='$id_produk'");
            }
            //kosongkan keranjang
            unset($_SESSION["keranjang"]);

            //tampilan dialihkan kehalaman nota pembelian barusan
            echo "<script>alert('Pembelian Sukses');</script>";
            echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";
        }
        ?>
</section>

</body>
</html>
<script>
    $(document).ready(function(){
        $.ajax({
            type: 'post',
            url:'dataprovinsi.php',
            success:function(hasil_provinsi)
            {
                $("select[name=nama_provinsi]").html(hasil_provinsi);
            }
        });
        $("select[name=nama_provinsi]").on("change",function(){
            //ambil id  provinsi yang dipilih  dari atribut pirbadi
           var id_provinsi_terpilih = $("option:selected",this).attr("id_provinsi");
           $.ajax({
               type:'post',
               url:'datadistrik.php',
               data: 'id_provinsi='+id_provinsi_terpilih,
               success:function(hasil_distrik)
               {
                $("select[name=nama_distrik]").html(hasil_distrik);
               }
           });
        });
        $.ajax({
            type:'post',
            url: 'dataekspedisi.php',
            success:function(hasil_ekspedisi)
            {
               $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
            }
        });
        $("select[name=nama_ekspedisi]").on("change",function(){
            //dapatdata ongkir

            //dapatkan ekspedisi terpilih
            var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();

            //mendapatkan id_distrik yang dipilih pengguna

            var distrik_terpilih = $("option:selected","select[name=nama_distrik]").attr("id_distrik");

            //mendaptkan total berat dari inputan
            var total_berat = $("input[name=total_berat]").val();
            $.ajax({
                type: 'post',
                url: 'datapaket.php',
                data: 'ekspedisi='+ekspedisi_terpilih+'&distrik='+distrik_terpilih+'&berat='+total_berat,
                success:function(hasil_paket)
                {
                    $("select[name=nama_paket]").html(hasil_paket);

                    //letakan nama ekspedisi terpilih di input ekspedisi
                    $("input[name=ekspedisi]").val(ekspedisi_terpilih);
                }
            })
        });
        $("select[name=nama_distrik]").on ("change", function(){
            var prov= $("option:selected",this).attr("nama_provinsi");
            var dis= $("option:selected",this).attr("nama_distrik");
            var tipe= $("option:selected",this).attr("tipe_distrik");
            var kodepos= $("option:selected",this).attr("kodepos");
            
            $("input[name=provinsi]").val(prov);
            $("input[name=distrik]").val(dis);
            $("input[name=tipe]").val(tipe);
            $("input[name=kodepos]").val(kodepos);

        });
        $("select[name=nama_paket]").on ("change",function(){
            var paket = $("option:selected",this).attr("paket");
            var ongkir = $("option:selected",this).attr("ongkir");
            var etd = $("option:selected",this).attr("etd");
            $("input[name=paket]").val(paket);
            $("input[name=ongkir]").val(ongkir);
            $("input[name=estimasi]").val(etd);
        })
    });
    </script>


<?php 
include 'footer.php';
?>