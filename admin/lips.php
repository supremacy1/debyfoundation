<?php

$subject='Domain Name | New Signup Details and Verification Link';
$msg_logo='<img src="http://www.domain.com/logo.png" width="250"><br><br>';

$dmessage="
<br><b>Congratulations!, your registration on domain.com was successful</b><br>
Click the link below (or copy and paste in your browser's address bar) to verify your account.<br><br>
http://www.domain.com/verify?email=".$demail."<br><br>

<b>BUSINESS NAME:</b> <br>".$dname."<br><br>

<b>LOGIN DETAILS</b><br>
URL: https://domain.com/login<br>
Email Address: ".$demail."<br><br>


<b>HOW TO PAY</b><br>
Login with your registered email and password to make payment online using your bank debit/credit card or make a direct bank deposit to the details below<br><br>

SMS your payment details to 08069524047, 07055055696 or email hello@domain.com<br><br>

Your subscription will be activated as soon as your payment is confirmed.<br><br>
";

$htmlContent =$msg_logo.$dmessage;

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: Enterpriza ERP <no-reply@domain.com>" . "\r\n";

@mail($demail,$subject,$htmlContent,$headers);
//copy admin
@mail("hello@enterpriza.com",$subject,$htmlContent,$headers);
//--------------------------------------------------------------

?>