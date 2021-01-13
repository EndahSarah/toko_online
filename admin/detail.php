
<h2>Detail Pembelian</h2>

<?php 
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan
ON pembelian.id_pelanggan=pelanggan.id_pelanggan
where pembelian.id_pembelian='$_GET[id]'" );
$detail = $ambil->fetch_assoc(); 

?>
<!---<pre><?php print_r($detail); ?> </pre>--->


 
<div class="row">
    <div class="col-md-4">
        <h3>Pembelian</h3>
        Status Barang : <?php echo $detail['status_pembelian']; ?><br> <br>
            No.Resi : <?php echo $detail['resi_pengiriman']; ?><br><br>
        <p>
            Tanggal : <?php echo $detail['tanggal_pembelian']; ?><br>
            Total : Rp. <?php echo number_format($detail['total_pembelian']); ?>,00
        </p>

    </div>
    <div class="col-md-4">
        <h3>Pelanggan</h3>
        <strong>NAMA : <?php echo $detail['nama_pelanggan']; ?></strong><br>
        <p>
            No.telp : <?php echo $detail['telephon_pelanggan']; ?> <br>
            E-mail : <?php echo $detail['email_pelanggan']; ?>
        </p>

    </div>
    <div class="col-md-4">
        <h3>Pengiriman</h3>
            <strong>ALAMAT : <?php echo $detail['tipe'];?><?php echo $detail['distrik'];?> <?php echo $detail['provinsi'];?> <?php echo $detail['kodepos'];?></strong><br>
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
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor=1; ?>
        <?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON
        pembelian_produk.id_produk=produk.id_produk
        WHERE pembelian_produk.id_pembelian='$_GET[id]'"); ?>
        <?php while($pecah=$ambil->fetch_assoc()){ ?>
       

       <tr>
            <td><?php echo $nomor; ?></td>
           <td><?php echo $pecah['nama_produk']; ?></td>
           <td>Rp. <?php echo number_format($pecah['harga_produk']); ?>,00</td>
           <td><?php echo $pecah['jumlah']; ?></td>
           <td>
           Rp. <?php echo number_format($pecah['harga_produk']*$pecah['jumlah']); ?>,00
           </td>


       </tr>
        <?php $nomor++; ?>    
        <?php } ;?>
    </tbody>
</table>