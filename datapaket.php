<?php
$ekspedisi=$_POST["ekspedisi"];
$distrik=$_POST["distrik"];
$berat=$_POST["berat"];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=501&destination=".$distrik."&weight=".$berat."&courier=".$ekspedisi,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: f9475a7e33bddb2833a840202d71ae34"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//   echo $response;
//   data yang didapat dalam bentuk json jadikan array
  $array_response = json_decode($response,true);
//   echo "<pre>";
//   print_r($array_response);
//   echo "</pre>";

$paket = $array_response["rajaongkir"]["results"]["0"]["costs"];

echo "<option value=''>--Pilih Paket--</option>";
foreach ($paket as $key => $tiap_paket)
{
    echo "<option
    paket='".$tiap_paket['service']."'
    ongkir='".$tiap_paket["cost"]["0"]["value"]."'
    etd='".$tiap_paket["cost"]["0"]["etd"]."'
    >";
    echo $tiap_paket["service"]." ";
    echo number_format($tiap_paket["cost"]["0"]["value"])." ";
    echo $tiap_paket["cost"]["0"]["etd"]." ";
    echo "</option>";
}
}

?>