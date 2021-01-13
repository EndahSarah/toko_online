<?php
session_start();
$koneksi = new mysqli("localhost","root","","ensatoko");

?>

<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        <br>

        <h3 align="center">ENSA Store Login</h3>
        <div class="container">
    <form action="#" method="post" class="px-3 py-3">
        <div class="form-group">
        <label for="exampleDropdownFormEmail1">Username</label>
        <input type="text"  name="nama" class="form-control" id="nama" placeholder="Masukan Username">
        </div>
        <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" name="pass" class="form-control" id="nama" placeholder="Password">
        </div>
        <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Ingat Saya
            </label>
        </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Login" name="clogin">
    </form>
    <?php
    
    if (isset($_POST['clogin']))
    {
      $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$_POST[nama]'
      AND password = '$_POST[pass]' ");
      $cocok = $ambil->num_rows;
      if($cocok==1){
        $_SESSION['admin']=$ambil->fetch_assoc();
        echo "<div class='alert-info'>Login Sukses</div>";
        echo "<meta http-equiv='refresh' content='1;url=index.php'>";
      }else{
        echo "<div class='alert-danger'>Login Gagal</div>";
        echo "<meta http-equiv='refresh' content='1;url=login.php'>";

      }
    
    } 
    ?>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="register.php">Belum Punya Akun? Registrasi</a>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>    </body>

</html>
