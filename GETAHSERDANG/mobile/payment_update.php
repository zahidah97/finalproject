<?php
error_reporting(0);
include_once("../php/dbconnect.php");
$userid = $_GET['userid'];
$mobile = $_GET['mobile'];
$amount = $_GET['amount'];

$data = array(
    'id' =>  $_GET['billplz']['id'],
    'paid_at' => $_GET['billplz']['paid_at'] ,
    'paid' => $_GET['billplz']['paid'],
    'x_signature' => $_GET['billplz']['x_signature']
);

$paidstatus = $_GET['billplz']['paid'];

if ($paidstatus=="true"){
  $receiptid = $_GET['billplz']['id'];
  $signing = '';
    foreach ($data as $key => $value) {
        $signing.= 'billplz'.$key . $value;
        if ($key === 'paid') {
            break;
        } else {
            $signing .= '|';
        }
    }
    
}
$sqlinsertpurchased = "INSERT INTO tbl_purchased(orderid,email,paid,status) VALUES('$receiptid','$userid', '$amount','paid')";
$sqldeletecart = "DELETE FROM tbl_carts WHERE email='$userid'";

if ($conn->exec($sqlinsertpurchased) && $conn->exec($sqldeletecart)) {
    echo "<script>alert('Payment Completed')</script>";
    echo "<script>window.location.replace('../php/cart.php')</script>";
}
//  echo '<br><br><body><div><h2><br><br><center>Your Receipt</center>
//  </h1>
//  <table border=1 width=80% align=center>
//  <tr><td>Receipt ID</td><td>'.$receiptid.'</td></tr><tr><td>Email to </td>
//  <td>'.$userid. ' </td></tr><td>Amount </td><td>RM '.$amount.'</td></tr>
//  <tr><td>Payment Status </td><td>'.$paidstatus.'</td></tr>
//  <tr><td>Date </td><td>'.date("d/m/Y").'</td></tr>
//  <tr><td>Time </td><td>'.date("h:i a").'</td></tr>
//  </table><br>
//  <p><center>Press back button to return to Simple ESHOP</center></p></div></body>';

else{
 echo "<script>alert('Payment Failed')</script>";
 echo "<script>window.location.replace('cart.php')</script>";
}
?>