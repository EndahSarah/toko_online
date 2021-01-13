<nav class="navbar sticky-top navbar-default">
<a class="navbar-brand" href="index.php"><b>ESTORE</b></a>

    <div class="container ">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Home
            <li><a href="keranjang.php">Keranjang</a></li>
            <?php if(isset($_SESSION["pelanggan"])): ?>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="riwayat.php">Riwayat Belanja</a></li>             
            <?php else: ?>  
                <li><a href="login.php">Login</a></li>
                <li><a href="daftar.php">Daftar</a></li>
            <?php endif ?>     
            <li><a href="checkout.php">Checkout</a></li>
           
        </ul>
        <form action="pencarian.php" method="GET" class="navbar-form navbar-right">
                <input type="text" class="form-control" name="keyword">
                <button class="btn bnt-prymary">Cari</button>
        </form>
    </div>
</nav>
