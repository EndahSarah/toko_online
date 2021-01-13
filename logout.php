<?php 
session_start();
session_destroy();//delete data pelanggan

echo "<script>alert('Anda Telah Logout');</script>";
echo "<script>location='index.php';</script>";;

?>