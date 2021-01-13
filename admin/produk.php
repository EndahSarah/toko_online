<h2>Halaman Produk</h2>
<div class="navbar-form navbar-right"><!-- buat button di kanan halaman dengan  bootstrap-->
<a href='index.php?halaman=tambahproduk' class="btn btn-primary">Tambah Data</a>
</div>
<br>
<table class="table table-bordered">
    <thed>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Berat</th>
            <th>Foto</th>
            <th>Deskripsi</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thed>
    <tbody>
        <?php $nomor=1; ?>
        <?php $ambil=$koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori"); ?>
        <?php while($pecah = $ambil->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['nama_kategori']; ?></td>
            <td><?php echo $pecah['nama_produk']; ?></td>
            <td>Rp. <?php echo number_format($pecah['harga_produk']); ?>,00</td>
            <td><?php echo $pecah['berat_produk']; ?></td>
            <td>
                <img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" width="100">
            </td>
            <td><?php echo $pecah['deskripsi_produk']; ?></td>
            <td><?php echo $pecah['stok_produk']; ?></td>
            <td>
                <a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk'];?>"
                 class="btn-danger btn">Hapus</a>
                <a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk'];?>" 
                class="btn-success btn">Ubah</a>
                <a href="index.php?halaman=detailproduk&id=<?php echo $pecah['id_produk'];?>" 
                class="btn-info btn">Detail</a>
            </td>
        </tr>
        <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table> 
