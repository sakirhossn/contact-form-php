<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Include autoload.php file
// require 'vendor/autoload.php';
// Create object of PHPMailer class
$mail = new PHPMailer();
$output = '';
$template_file = "phpmailer/email-template.php";

if (isset($_POST['submit']) and !empty($_POST['email']) and !empty($_POST['message']) and !empty($_POST['name'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $template_file = "phpmailer/email-template.php";
  $swap_var = array(
    "{TO_NAME}" => $_POST['name'],
    "{TO_EMAIL}" =>  $_POST['email'],
    "{TO_MESSAGE}" => $_POST['message'],
    "{TO_IMG1}" => "https://get-img.crazymazic.com/image-1.png",
    "{TO_IMG3}" => "https://get-img.crazymazic.com/image-2.png",
    "{TO_IMG2}" => "https://get-img.crazymazic.com/image-3.png",
    "{TO_SITE}" => "https://crazymazic.com",

  );
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    // Gmail ID which you want to use as SMTP server
    $mail->Username = 'skali721150@gmail.com';
    // Gmail Password
    $mail->Password = 'sakir9196';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email ID from which you want to send the email
    $mail->setFrom($email, $name);
    // Recipient Email ID where you want to receive emails
    $mail->addAddress('sksakirhossain8@gmail.com');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Get Connect' . ' ' . 'CrazyMazic';
    // load in the template file for processing (after we make sure it exists)
    if (file_exists($template_file))
      $email_message = file_get_contents($template_file);
    else
      die("Unable to locate your template file");

    // search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
    foreach (array_keys($swap_var) as $key) {
      if (strlen($key) > 2 && trim($swap_var[$key]) != '')
        $email_message = str_replace($key, $swap_var[$key], $email_message);
    }
    $mail->Body = $email_message;

    $mail->send();
    $output = '<div class="alert alert-success"><h5>Thankyou! ' . $name . ' for contacting us, We' . 'll get back to you soon!</h5></div>';
  } catch (Exception $e) {
    $output = '<div class="alert alert-danger">
                  <h5>' . $e->getMessage() . '</h5></div>';
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us Using PHPMailer & Gmail SMTP</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css' />
</head>

<body class="bg-info">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 mt-3">
        <div class="card border-danger shadow">
          <div class="card-header bg-danger text-light">
            <h3 class="card-title">Contact Us</h3>
          </div>
          <div class="card-body px-4">
            <form action="#" method="POST">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required>
              </div>
              <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter E-Mail" required>
              </div>
              <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" required>
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write Your Message" required></textarea>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" value="Send" class="btn btn-danger btn-block" id="sendBtn">
              </div>
              <div class="form-group">
                <?php echo $output; ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>