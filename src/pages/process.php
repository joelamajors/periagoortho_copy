---
layout: phplayout
name: PHP Only Page
---
<?php

  //form submitted
  $from_user = $_POST['ContactName'];
  $from_patient = $_POST['PatientName'];
  $from_phone = $_POST['ContactPhone'];
  $from_email = $_POST['ContactEmail'];
  $from_message = $_POST['ContactMessage'];

  //verify captcha
  $recaptcha_secret = "6Lc3CDcUAAAAACKDXFlLb2zViMbv3sDnr35zsC8t";
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
  $response = json_decode($response, true);

  if($response["success"] === true) {
    // Send Email
    $subject = "Patient Contact Email";
    $txt = "<h3>You have a new contact email from PeriagoOrtho</h3>";
    $txt = $txt."<p>From User: ".$from_user."<br />";
    $txt = $txt."<p>Regarding Patient: ".$from_patient."<br />";
    $txt = $txt."User Phone: ".$from_phone."<br />";
    $txt = $txt."User Email: ".$from_email."<br />";
    $txt = $txt."User Message: ".$from_message."</p>";
    $txt = $txt."<p>Thanks,<br /> PeriagoOrtho Automated Contact System</p>";

    $to = "info@periagoortho.com";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: postmaster@periagoortho.com";
    mail($to,$subject,$txt,$headers);
    echo "<script type='text/javascript'>window.location='/thankyou.html'</script>";
  } else {
    // Failed Request
    echo "<script type='text/javascript'>window.location='/contact.html'</script>";
  }

?>
