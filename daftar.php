<?php include 'koneksi.php'; ?>
<html>
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>    
<body>
    <?php include 'menu.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Daftar Pelanggan</h3>
                </div>
                <div class="panel-body">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="nama">
                            </div> 
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email"
                                required>
                            </div> 
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="password"
                                required>
                            </div> 
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-7">
                                <textarea class="form-control" name="alamat"
                                required></textarea>
                            </div>  
                            </div>  
                            <div class="form-group">
                            <label class="control-label col-md-3">Telp/HP</label>
                            <div class="col-md-7">
                                 <input type="text" class="form-control" name="telephon"
                                 required>
                            </div>  
                            </div>  
                            <div class="form-grouop">
                                <div class="col-md-7 col-md-offset-3">
                                    <button class="btn btn-primary" name="daftar">Daftar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    //jika tekan tombol daftar
                    if (isset($_POST['daftar']))
                    {
                        //ambil isi nmaa,email,paa,alamat,telephon
                        $nama=$_POST["nama"];
                        $email=$_POST["email"];
                        $password=$_POST["password"];
                        $telephon=$_POST["telephon"];
                        $alamat=$_POST["alamat"];
                        //cek emailsudah digunakan atau belum
                        $ambil=$koneksi->query("SELECT * FROM pelanggan
                        WHERE email_pelanggan='$email'");
                        $yangcocok=$ambil->num_rows; //menghitung email yang ada tiap row
                        if ($yangcocok==1)
                        {
                            echo "<script>alert('Pendaftaran Gagal, Email Sudah Digunakan');</script>";
                            echo "<script>location='daftar.php';</script>";
                        }else{
                            //query insert ke tabel pelanggan
                            $koneksi->query("INSERT INTO pelanggan
                            (email_pelanggan,password_pelanggan,nama_pelanggan,
                            telephon_pelanggan,alamat_pelanggan)
                            VALUES ('$email','$password','$nama','$telephon','$alamat') ");
                            echo "<script>alert('Pendaftaran Sukses, Silahkan Login');</script>";
                            echo "<script>location='login.php';</script>";
                            
                        }

                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>    
</body>
</html>